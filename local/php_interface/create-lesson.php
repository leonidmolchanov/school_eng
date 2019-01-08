<?
global $USER;
    function getNextWeek($id, $name, $from, $to, $group, $audit, $repeat)
    {
        $newfrom= date("Y-m-d H:i:s", strtotime($from. ' +1 week'));
        $newto= date("Y-m-d H:i:s", strtotime($to. ' +1 week'));

        echo $newfrom;
        echo $newto;
        echo $audit;
        $check=false;
        if (CModule::IncludeModule("iblock")):
            # show url my elements
            $my_elements = CIBlockElement::GetList(
                Array("PROPERTY_TO" => "ASC"),
                Array("IBLOCK_CODE" => 'LESSON',
                    'PROPERTY_AUDITORIUM'=> $audit,
                    '>=PROPERTY_FROM' =>$newfrom,
                    '<=PROPERTY_TO' => $newto
                ),
                false,
                false,
                Array('ID', 'NAME', 'PROPERTY_FROM', 'PROPERTY_TO', 'PROPERTY_GROUP', 'PROPERTY_AUDITORIUM')
            );

            while ($ar_fields = $my_elements->GetNext()) {
                $check=true;
            }
        endif;

        if(!$check){
            setLesson($id, $name, $newfrom, $newto, $group, $audit, $repeat);
        }
    }

    function getLessons()
    {
        echo date("Y-m-d H:i:s");
        echo date("Y-m-d H:i:s", strtotime( ' +1 week'));
        if (CModule::IncludeModule("iblock")):
            # show url my elements
            $my_elements = CIBlockElement::GetList(
                Array("PROPERTY_TO" => "ASC"),
                Array("IBLOCK_CODE" => 'LESSON',
                    '>=PROPERTY_FROM' => date("Y-m-d H:i:s"),
                    '<=PROPERTY_TO' =>  date("Y-m-d H:i:s", strtotime( ' +1 week')),
                    "PROPERTY_REPEAT" => 1),
                false,
                false,
                Array('ID', 'NAME', 'PROPERTY_FROM', 'PROPERTY_TO', 'PROPERTY_GROUP', 'PROPERTY_AUDITORIUM', 'PROPERTY_REPEAT')
            );

            while ($ar_fields = $my_elements->GetNext()) {
                print_r($ar_fields);
                getNextWeek($ar_fields['ID'], $ar_fields['NAME'], $ar_fields['PROPERTY_FROM_VALUE'], $ar_fields['PROPERTY_TO_VALUE'], $ar_fields['PROPERTY_GROUP_VALUE'], $ar_fields['PROPERTY_AUDITORIUM_VALUE'], $ar_fields['PROPERTY_REPEAT_VALUE']);
            }
        endif;

    }


    function             setLesson($id, $name, $newfrom, $newto, $group, $audit, $repeat){
        $iblockid=0;
        if(CModule::IncludeModule("iblock"))
        {

            $ib_list = CIBlock::GetList(
                Array(),
                Array(
                    "CODE" => "LESSON",
                    "CHECK_PERMISSIONS" => "N"
                )
            );
            while($arIBlock = $ib_list->GetNext()) //цикл по всем блокам
            {
                $iblockid = $arIBlock["ID"];

            }
        }
        $el = new CIBlockElement;

        $PROP = array();
        $PROP["AUDITORIUM"] = $audit;  // учитель для группы
        $PROP["FROM"] = date("d.m.Y H:i", strtotime($newfrom));
        $PROP["TO"] =date("d.m.Y H:i", strtotime($newto));
        $PROP["GROUP"] = $group;  // учитель для группы
        $PROP["REPEAT"] = $repeat;  // учитель для группы

        $arLoadProductArray = Array(
            "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
            "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
            "IBLOCK_ID"      => $iblockid,
            "PROPERTY_VALUES"=> $PROP,
            "NAME"           => $name,
            "ACTIVE"         => "Y"
        );
        echo date("d.m.Y H:i", strtotime($newfrom));
        if($PRODUCT_ID = $el->Add($arLoadProductArray))
            echo "New ID: ".$PRODUCT_ID;
        else
            echo "Error: ".$el->LAST_ERROR;
    }
    getLessons();



?>