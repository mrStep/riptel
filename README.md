riptel
======

Скачивание базы данных телефонов с фейсбука

Как известно (http://devteev.blogspot.ru/2013/05/blog-post_21.html), при восстановлении пароля на фейсбуке требуется ввести номер телефона. После этого нам выводится имя и фотография владельца введенного номера. Цель данной програмы - выкачать всю базу номеров с фейсбука.

TODO
======

	Основная проблема в том, что фейсбук после нескольких запросах подряд начинает выдавать капчу. Эта проблема должна была решиться добавлением функции работы через прокси, которые берутся из файла. Но почему-то это не работает, при том что если например подключить VPN и получить другой IP, капча исчезает.
	Среди других целей - реализация уязвимости, описанной по приведенной выше ссылке, на сайтах Вконтакте и Gmail.