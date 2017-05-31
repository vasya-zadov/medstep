<?php

/*
 * The MIT License
 *
 * Copyright 2016 Alexander Larkin <lcdee@andex.ru>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Description of Backup
 *
 * @author Alexander Larkin <lcdee@andex.ru>
 */
class Backup
{

    public function backupDbDownload()
    {
        $data = $this->backupTables();
        $name = $this->getBackupFileName();
        header("Content-type: application/octet-stream");
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"db-backup-".$name.".sql\"");
        header("Content-length: ".strlen($data));
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $data;
    }

    public function backupDbSave()
    {
        $name = $this->getBackupFileName();
        $handle = fopen(app()->basePath.DS.'runtime'.DS.'db-backup-'.$name.'.sql', 'w+');
        fwrite($handle, $this->backupTables());
        fclose($handle);
        return $name.'.sql';
    }

    public function backupArchiveDownload()
    {
        $name = $this->backupArchive();
        ignore_user_abort(true);
        header("Content-type: application/octet-stream");
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"{$name}\"");
        header("Content-length: ".filesize(app()->basePath.DS.'runtime'.DS.$name));
        header("Pragma: no-cache");
        header("Expires: 0");
        ob_clean();
        flush();
        if(!connection_aborted())
        {
            readfile(app()->basePath.DS.'runtime'.DS.$name);
        }
        unlink(app()->basePath.DS.'runtime'.DS.$name);
        app()->end();
    }

    public function backupArchiveSave()
    {
        return $this->backupArchive();
    }

    public static function ftpBackup()
    {
        if(
            (!(bool)app()->settings->backupInterval) ||
            (!(bool)app()->settings->backupServerHost) ||
            (!(bool)app()->settings->backupServerLogin) ||
            (!(bool)app()->settings->backupServerPassword))
        {
            return false;
        }
        if((strtotime(app()->settings->backupLatestBackupDate) + app()->settings->backupInterval * ADYN_BACKUP_DELAY_MULTIPLIER) < time())
        {
            app()->db->createCommand('UPDATE '.app()->db->tablePrefix.'settings SET value="'.date('Y-m-d H:i:s').'" where name="backupLatestBackupDate";')->execute();
            ExtHelpers::assyncRoutine('/index.php?r=/system/ftpbackup');
        }
    }

    public function performFtpBackup()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        $ftp = new FtpBackup;
        $ftp->cleanupSrver();
        $sqlFile = app()->basePath.DS.'runtime'.DS.'db-backup-'.$this->backupDbSave();
        $ftp->uploadFile($sqlFile);
        $archiveFile = app()->basePath.DS.'runtime'.DS.$this->backupArchiveSave();
        $ftp->uploadFile($archiveFile);
        $ftp->close();
        unlink($sqlFile);
        unlink($archiveFile);
    }

    private function backupArchive()
    {
        set_time_limit(0);
        $name = 'backup-'.$this->getBackupFileName().'.tar';
        $archiver = new PharData(app()->basePath.DS.'runtime'.DS.$name);
        $archiver->buildFromDirectory(app()->basePath.'/..');
        $archiver->compress(Phar::GZ);
        unset($archiver);
        unlink(app()->basePath.DS.'runtime'.DS.$name);
        return $name.'.gz';
    }

    private function getBackupFileName()
    {
        return ExtHelpers::translit(app()->name, true).'-'.date('YmdHis');
    }

    private function backupTables($tables = '*')
    {
        $db = app()->db;

        if($tables == '*')
        {
            $tables = array();
            $result = $db->createCommand('SHOW TABLES')->queryAll(false);
            foreach($result as $row)
            {
                $tables[] = $row[0];
            }
        }
        else
        {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }
        $return = '';
        foreach($tables as $table)
        {
            $result = $db->createCommand('SELECT * FROM '.$table)->queryAll(false);

            $return.= 'DROP TABLE '.$table.';';
            $row2 = $db->createCommand('SHOW CREATE TABLE '.$table)->queryRow(false);
            $return.= "\n\n".$row2[1].";\n\n";

            foreach($result as $row)
            {
                $return.= 'INSERT INTO '.$table.' VALUES(';
                $values = array();
                foreach($row as $field => $value)
                {
                    $values[$field] = addslashes($value);
                    $values[$field] = preg_replace("/\n/", "\\n", $values[$field]);
                    $values[$field] = '"'.($values[$field]).'"';
                }
                $return.=implode(',', $values);
                $return.= ");\n";
            }
            $return.="\n\n\n";
        }
        return $return;
    }

}
