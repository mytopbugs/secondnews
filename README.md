# secondnews

## Техническое задание (дополненное)

### Таблицы в БД

#### config:
1. **news_of_page** количество новостей на странице
2. **recommend_max_count** максимальное количество рекомендуемых новостей
	
#### news	 
1. id
2. name - Название (varchar, логично заголовок ограничить в размере)
3. datetime - Дата и время публикации с GTK
4. preview - анонс новости (varchar, так как анонс ограничен в размере, может быть HTML)
5. description - полный текст новости с тегами экранированными (text / может быть HTML)
6. image_preview - картинка в анонсе (NOT NULL / base64)
7. image_content - картинка в тексте (NOT NULL / base64)
8. author - ФИО автора (NOT NULL)
9. slug - id рекомендуемых новостей (JSON) {12,3,45} / {} / {23,12} 

** Для списка новостей выводим: **
	Название
	Дата
	Краткое описание
	Картинку для превью
	Ссылку на детальную страницу
	Автор

### Endpoints
1. Список новостей
	HOST/news_list?page=1
		- Без параметра, то первая страница
		- Если нет такой страницы, то последняя и исключение в лог складывать (опция)
	- Данные по новостям в списке: 
		+ Название
		+ Дата
		+ Краткое описание
		+ Картинку для превью
		+ Ссылку на детальную страницу (генерировать endpoint)
		+ Автор
2. Детальная новость 
	HOST/current_new?item=1
		- Без параметра - выводить свежую
	- Данные детальной новости
		+ Название
		+ Дата
		+ Полное описание
		+ Детальная картинка
		+ Автор
		+ Массив рекомендуемых новостей
			* Название
			* Дата
			* Картинку для превью
			* Краткое описание
			* Ссылку на детальную страницу
			* Автор

### Оформление кода

- PSR-12
- Laravel:last
- БД MySQL:last
- Docker (чтоб развернуть и собрать)

## Этапы работ 

1. Обеспечить сохранение БД
2. Подлючить Laravel
3. Соединить с БД
4. Добавить (сгенерировать) класс для таблицы
5. Вывести на страницу
6. Добавить чистые endpoints и проверить
7. Добавить автотесты
8. Отключить или сделать акцент на рендере новостей