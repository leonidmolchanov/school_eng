<?
    $date = date("Y-m-d  H:i:s", strtotime('-15 minutes'));
    $dateEND = date("Y-m-d H:i:s", strtotime('+15 minutes'));
    echo $dateEND;
    $lessons = [];
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList(
            Array("PROPERTY_TO" => "ASC"),
            Array("IBLOCK_CODE" => 'LESSON',
                '>=PROPERTY_FROM' => $date,
                '<=PROPERTY_FROM' => $dateEND,),
            false,
            false,
            Array('ID', 'NAME', 'PROPERTY_FROM', 'PROPERTY_TO', 'PROPERTY_GROUP', 'PROPERTY_AUDITORIUM')
        );

        while ($ar_fields = $my_elements->GetNext()) {
            getJournal($ar_fields['ID'], $ar_fields['PROPERTY_GROUP_VALUE'], $ar_fields['NAME']);
        }
    endif;

    function createJournal($id, $lesson, $lessonName, $student)
    {
        $iblockid = 0;
        if (CModule::IncludeModule("iblock")) {

            $ib_list = CIBlock::GetList(
                Array(),
                Array(
                    "CODE" => "JOURNAL",
                    "CHECK_PERMISSIONS" => "N"
                )
            );
            while ($arIBlock = $ib_list->GetNext()) //цикл по всем блокам
            {
                $iblockid = $arIBlock["ID"];

            }
        }
        $el = new CIBlockElement;

        $PROP = array();
        $PROP["GROUPID"] = $id;
        $PROP["LESSONID"] = $lesson;
        $PROP["NOTBE"] = $student;

        $arLoadProductArray = Array(
            "MODIFIED_BY" => 1, // элемент изменен текущим пользователем
            "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
            "IBLOCK_ID" => $iblockid,
            "PROPERTY_VALUES" => $PROP,
            "NAME" => $lessonName . "(" . date("d.m.Y", strtotime(now)) . ")",
            "ACTIVE" => "Y"
        );
        $request = "";
        if ($PRODUCT_ID = $el->Add($arLoadProductArray))
            $request = 'Success';
        else
            $request = 'Error' . $_REQUEST["name"];

    }

    function getStudent($id, $lesson, $lessonName)
    {
        echo $id;
        $student = [];
        echo "journal";
        if (CModule::IncludeModule("iblock")):
            # show url my elements
            $my_elements = CIBlockElement::GetList(
                Array("ID" => "ASC"),
                Array("IBLOCK_CODE" => 'GROUP_STRUCTURE',
                    "PROPERTY_GROUP_ID" => $id),
                false,
                false,
                Array('ID', 'PROPERTY_STUDENT_ID')
            );

            while ($ar_fields = $my_elements->GetNext()) {
                array_push($student, $ar_fields['PROPERTY_STUDENT_ID_VALUE']);
            }
        endif;
        print_r($student);
        if (!empty($student)) {
            createJournal($id, $lesson, $lessonName, $student);
        }
    }

    ;
    function getJournal($id, $group, $name)
    {
        $check = false;
        if (CModule::IncludeModule("iblock")):
            $my_elements = CIBlockElement::GetList(
                Array("PROPERTY_TO" => "ASC"),
                Array("IBLOCK_CODE" => 'JOURNAL',
                    'PROPERTY_LESSONID' => $id),
                false,
                false,
                Array('ID', 'NAME', 'PROPERTY_FROM', 'PROPERTY_TO', 'PROPERTY_GROUP', 'PROPERTY_AUDITORIUM')
            );

            while ($ar_fields = $my_elements->GetNext()) {
                $check = true;
            }
        endif;
        if (!$check) {
            getStudent($group, $id, $name);
        }
    }
?>