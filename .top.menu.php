<?
$aMenuLinks = Array(
	Array(
		"Расписание", 
		"/schedule.php", 
		Array(), 
		Array("label"=>"table"), 
		"" 
	),
	Array(
		"Управление", 
		"/control/", 
		Array(), 
		Array("label"=>"cogwheels"), 
		"" 
	),
	Array(
		"Сообщения", 
		"/chat.php", 
		Array(), 
		Array("label"=>"comments"), 
		"" 
	),
	Array(
		"Пробные занятия", 
		"/trial/", 
		Array(), 
		Array("label"=>"user_add"),
        "CSite::InGroup(array(1,9,16,17,18))"

    ),
	Array(
		"Карточка студента", 
		"/studentCard/", 
		Array(), 
		Array("label"=>"calendar"),
        "CSite::InGroup(array(1,9,16,17,18))"

    ),
	Array(
		"Карточка сотрудника", 
		"/worker-card.php", 
		Array(), 
		Array("label"=>"user"),
        "CSite::InGroup(array(1,9,16,17,18))"

    ),
	Array(
		"Аналитика", 
		"/analytics/", 
		Array(), 
		Array("label"=>"charts"), 
		"" 
	),
	Array(
		"Платежи", 
		"/transactions/index.php",
		Array(), 
		Array("label"=>"coins"),
        "CSite::InGroup(array(1,16,17))"
	),
	Array(
		"Отработки", 
		"/adjustment.php", 
		Array(), 
		Array("label"=>"edit"),
        "CSite::InGroup(array(1,9,16,17,18))"

    ),
	Array(
		"Журналы", 
		"/journal.php", 
		Array(), 
		Array("label"=>"check"),
        "CSite::InGroup(array(1,9,16,17,18))"

    ),
	Array(
		"Личный кабинет", 
		"/profile/", 
		Array(), 
		Array("label"=>"globe"), 
		"" 
	),
	Array(
		"О нас", 
		"/about/", 
		Array(), 
		Array("label"=>"rabbit"), 
		"" 
	),
	Array(
		"Выход", 
		"/index.php?logout=yes", 
		Array(), 
		Array("label"=>"exit"), 
		"" 
	)
);
?>