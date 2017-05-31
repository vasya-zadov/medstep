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

CREATE TABLE `<?=$tablePrefix;?>pages` (
  `id` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL COMMENT 'Заголовок',
  `headingOne` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text NOT NULL COMMENT 'Описание',
  `keywords` varchar(255) NOT NULL,
  `text` text NOT NULL COMMENT 'Текст',
  `date` date NOT NULL COMMENT 'Дата',
  `type` int(1) NOT NULL,
  `image` varchar(255) NOT NULL,
  `lang` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `<?=$tablePrefix;?>pages`
  ADD PRIMARY KEY (`id`);

INSERT INTO `<?=$tablePrefix;?>pages` (`id`, `caption`, `headingOne`, `alias`, `description`, `keywords`, `text`, `date`, `type`, `image`, `lang`) VALUES
(1, 'Главная страница', 'Главная страница', '', '', '', '<p></p>\r\n', '2016-02-18', 1, '', ''),
(2, 'Страница в разработке', '', 'test', '', '', '<p>Страница в разработке</p>\r\n', '2016-02-18', 1, '', '');


ALTER TABLE `<?=$tablePrefix;?>pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;