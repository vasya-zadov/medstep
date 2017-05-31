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
 * Author:  Alexander Larkin <lcdee@andex.ru>
 * Created: 19.02.2016
 */

CREATE TABLE `<?=$tablePrefix;?>menu` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'id родителя',
  `iNumber` int(11) NOT NULL COMMENT 'Порядок',
  `caption` varchar(255) NOT NULL COMMENT 'Заголовок',
  `alias` varchar(255) NOT NULL COMMENT 'Ссылка',
  `active` tinyint(1) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `node_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `<?=$tablePrefix;?>menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

INSERT INTO `<?=$tablePrefix;?>menu` (`id`, `parent_id`, `iNumber`, `caption`, `alias`, `active`, `controller`, `node_id`, `title`, `image`) VALUES
(1, 0, 1, 'Главное меню', '', 1, '', 0, '', ''),
(2, 0, 2, 'Скрытое меню', '', 1, '', 0, '', '');

ALTER TABLE `<?=$tablePrefix;?>menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;