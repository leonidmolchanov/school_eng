<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<?
$userArr=[];
if (!empty($arResult["DISPLAY_PROPERTIES"]["BE"]["DISPLAY_VALUE"]))
{
if(is_array($arResult["DISPLAY_PROPERTIES"]["BE"]["DISPLAY_VALUE"])){
foreach($arResult["DISPLAY_PROPERTIES"]["BE"]["DISPLAY_VALUE"] as $item):
    array_push($userArr, $item);
    endforeach;
}
else{
    array_push($userArr, $arResult["DISPLAY_PROPERTIES"]["BE"]["DISPLAY_VALUE"]);

}
}

if (!empty($arResult["DISPLAY_PROPERTIES"]["NOTBE"]["DISPLAY_VALUE"]))
{
    if(is_array($arResult["DISPLAY_PROPERTIES"]["NOTBE"]["DISPLAY_VALUE"])){
        foreach($arResult["DISPLAY_PROPERTIES"]["NOTBE"]["DISPLAY_VALUE"] as $item):
            array_push($userArr, $item);
        endforeach;
    }
    else{
        array_push($userArr, $arResult["DISPLAY_PROPERTIES"]["NOTBE"]["DISPLAY_VALUE"]);

    }
}

if (!empty($arResult["DISPLAY_PROPERTIES"]["DISEASE"]["DISPLAY_VALUE"]))
{
    if(is_array($arResult["DISPLAY_PROPERTIES"]["DISEASE"]["DISPLAY_VALUE"])){
        foreach($arResult["DISPLAY_PROPERTIES"]["DISEASE"]["DISPLAY_VALUE"] as $item):
            array_push($userArr, $item);
        endforeach;
    }
    else{
        array_push($userArr, $arResult["DISPLAY_PROPERTIES"]["DISEASE"]["DISPLAY_VALUE"]);

    }
}
$userArrAdj=[];
if($arResult["DISPLAY_PROPERTIES"]["LESSONID"]["DISPLAY_VALUE"]):
if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'ADJUSTMENT', 'PROPERTY_ALESSONID'=>$arResult["DISPLAY_PROPERTIES"]["LESSONID"]["DISPLAY_VALUE"]),
        false,
        false,
        Array('ID', 'NAME', 'PROPERTY_USERID')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        array_push($userArrAdj, $ar_fields['PROPERTY_USERID_VALUE']);

    }
endif;
    endif;
$students=[];
if (CModule::IncludeModule("iblock") && !empty($userArr)):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'STUDENTS',
            "ID"=>$userArr),
        false,
        false,
        Array('ID', 'PROPERTY_DOGOVOR','PROPERTY_NAME','PROPERTY_LAST_NAME','PROPERTY_SECOND_NAME')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        array_push($students, $ar_fields);
    }
endif;
$studentsAdj=[];
if (CModule::IncludeModule("iblock") && !empty($userArrAdj)):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => 'STUDENTS',
            "ID"=>$userArrAdj),
        false,
        false,
        Array('ID', 'PROPERTY_DOGOVOR','PROPERTY_NAME','PROPERTY_LAST_NAME','PROPERTY_SECOND_NAME')
    );

    while($ar_fields = $my_elements->GetNext())
    {
       $studentsAdj[$ar_fields['ID']]=$ar_fields;
    }
endif;
?>
<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
    <h3 class="page-header page-header-top"><?=$arResult["NAME"]?></h3>
<?endif;?>
<table class="table table-borderless" id="journal-table">
    <thead>
    <tr>
        <th class="text-center">#</th>
        <th>Не был</th>
        <th>Был</th>
        <th class="cell-small text-center">Болезнь/Пропустил</th>
        <th>№ договора</th>
        <th class="hidden-xs hidden-sm">Имя</th>
        <th class="hidden-xs hidden-sm">Фамилия</th>
    </tr>
    </thead>
    <tbody>
    <?
    $i=1;
    foreach($students as $item):
?>
        <tr
            <?
                if(in_array($item["ID"],$arResult["DISPLAY_PROPERTIES"]["BE"]["DISPLAY_VALUE"])):?> class="success"<?endif;?>
                <? if(in_array($item["ID"],$arResult["DISPLAY_PROPERTIES"]["DISEASE"]["DISPLAY_VALUE"])):?> class="warning"<?endif;?>
                <? if(in_array($item["ID"],$arResult["DISPLAY_PROPERTIES"]["NOTBE"]["DISPLAY_VALUE"])):?> class="active"<?endif;
                if($item["ID"]==$arResult["DISPLAY_PROPERTIES"]["BE"]["DISPLAY_VALUE"]):
                    ?>class="success"<?endif;?>
                <? if($item["ID"]==$arResult["DISPLAY_PROPERTIES"]["DISEASE"]["DISPLAY_VALUE"]):
                    ?>class="warning"<?endif;?>
                <? if($item["ID"]==$arResult["DISPLAY_PROPERTIES"]["NOTBE"]["DISPLAY_VALUE"]):
                    ?>class="active"
                <?endif;?>
        data-id="<?=$item['ID']?>">
            <td class="text-center"><?=$i?></td>
            <td class="cell-small text-center"><input name="selectradio<?=$item["ID"]?>" type="radio"
                    <?
                    if(is_array($arResult["DISPLAY_PROPERTIES"]["NOTBE"]["DISPLAY_VALUE"])):
                        if(in_array($item["ID"],$arResult["DISPLAY_PROPERTIES"]["NOTBE"]["DISPLAY_VALUE"])):?> checked<?endif;
                    else:
                        if($item["ID"]==$arResult["DISPLAY_PROPERTIES"]["NOTBE"]["DISPLAY_VALUE"]):
                            ?>checked
                        <?endif;
                    endif;?>
                                                      onchange="setNotBe(this)"></td>
            <td class="cell-small text-center"><input name="selectradio<?=$item["ID"]?>" type="radio"
                    <?
                    if(is_array($arResult["DISPLAY_PROPERTIES"]["BE"]["DISPLAY_VALUE"])):
                        if(in_array($item["ID"],$arResult["DISPLAY_PROPERTIES"]["BE"]["DISPLAY_VALUE"])):?> checked<?endif;
                    else:
                        if($item["ID"]==$arResult["DISPLAY_PROPERTIES"]["BE"]["DISPLAY_VALUE"]):
                            ?>checked
                        <?endif;
                    endif;?>
                                                      onchange="setFront(this)"></td>
            <td class="cell-small text-center"><input name="selectradio<?=$item["ID"];?>" type="radio"
                    <?
                    if(is_array($arResult["DISPLAY_PROPERTIES"]["DISEASE"]["DISPLAY_VALUE"])):
                    if(in_array($item["ID"],$arResult["DISPLAY_PROPERTIES"]["DISEASE"]["DISPLAY_VALUE"])):?> checked<?endif;
                    else:
if($item["ID"]==$arResult["DISPLAY_PROPERTIES"]["DISEASE"]["DISPLAY_VALUE"]):
    ?>checked
                        <?endif;
                    endif;?>


                                                      onchange="setDisease(this)"></td>
            <td><a href="javascript:void(0)"><?=$item["PROPERTY_DOGOVOR_VALUE"]?></a></td>
            <td class="hidden-xs hidden-sm"><?=$item["PROPERTY_NAME_VALUE"]?></td>
            <td class="hidden-xs hidden-sm"><?=$item["PROPERTY_LAST_NAME_VALUE"]?></td>
        </tr>
    <?
    $i++;
    endforeach;
    ?>
    <?

if($arResult["DISPLAY_PROPERTIES"]["LESSONID"]["DISPLAY_VALUE"]):
    if (CModule::IncludeModule("iblock")):
        # show url my elements
        $my_elements = CIBlockElement::GetList (
            Array("ID" => "ASC"),
            Array("IBLOCK_CODE" => 'ADJUSTMENT', 'PROPERTY_ALESSONID'=>$arResult["DISPLAY_PROPERTIES"]["LESSONID"]["DISPLAY_VALUE"]),
            false,
            false,
            Array('ID', 'NAME', 'PROPERTY_USERID' , 'PROPERTY_STATUS')
        );

        while($ar_fields = $my_elements->GetNext())
        {
            if($ar_fields['PROPERTY_STATUS_VALUE']!=='3'):

            ?>
          <tr data-adj="<?=$ar_fields['ID']?>"
            <?
            if($ar_fields['PROPERTY_STATUS_VALUE']=='0'):?> class="active"<?endif;?>
              <?if($ar_fields['PROPERTY_STATUS_VALUE']=='1'):?> class="success"<?endif;?>
              <?if($ar_fields['PROPERTY_STATUS_VALUE']=='2'):?> class="warning"<?endif;?>

              data-id="<?=$item['ID']?>">
              <td class="text-center"><?=$i?></td>
              <td class="cell-small text-center"><input name="selectradio2<?=$item["ID"]?>" type="radio"
                   <?if($ar_fields['PROPERTY_STATUS_VALUE']=='1'):?> checked<?endif;?>
                                                      onchange="setNotBe(this)"></td>
              <td class="cell-small text-center"><input name="selectradio2<?=$item["ID"]?>" type="radio"
                      <?if($ar_fields['PROPERTY_STATUS_VALUE']=='1'):?> checked<?endif;?>
                                                        onchange="setFront(this)"></td>
            <td class="cell-small text-center">-</td>
            <td><a href="javascript:void(0)"><?=$studentsAdj[$ar_fields['PROPERTY_USERID_VALUE']]["PROPERTY_DOGOVOR_VALUE"]?></a>(Отработка)</td>
            <td class="hidden-xs hidden-sm"><?=$studentsAdj[$ar_fields['PROPERTY_USERID_VALUE']]["PROPERTY_NAME_VALUE"]?></td>
            <td class="hidden-xs hidden-sm"><?=$studentsAdj[$ar_fields['PROPERTY_USERID_VALUE']]["PROPERTY_LAST_NAME_VALUE"]?></td>
        </tr>
    <?
               endif;

        }
    endif;
endif;
    ?>
    </tbody>
</table>
<input type="submit" onclick="saveJournal()" class="btn btn-success ui-wizard-content ui-formwizard-button"
       id="save-journal-button" value="Сохранить">


<?
$adjustment=[];


    ?>

<script>
    function saveJournal() {
        obj={};
        obj.be=[];
        obj.notbe=[];
        obj.disease=[];
        obj.adj=[];
        obj.id = <?=$arResult["ID"]?>

       $("#journal-table tbody tr").each(function (index) {
           if(!this.dataset.adj) {
               if (this.className == "warning") {
                   obj.disease.push(this.dataset.id)
               }
               else if (this.className == "success") {
                   obj.be.push(this.dataset.id)
               }
               else if (this.className == "active") {
                   obj.notbe.push(this.dataset.id)
               }
           }
           else{
               elem={'status':0, 'id': Number(this.dataset.adj)}
               if (this.className == "warning") {
                   elem.status = 2
               }
               else if (this.className == "success") {
                   elem.status = 1
               }
               else if (this.className == "active") {
                   elem.status = 0
               }
               obj.adj.push(elem)
           }
        })
console.log(obj)
        BX.ajax({
            url: '/api.php',
            data: {
                sessid: BX.bitrix_sessid(),
                type: 'editJournal',
                id: <?=$arResult["ID"]?>,
                lessonid: <?=$arResult["DISPLAY_PROPERTIES"]["LESSONID"]["DISPLAY_VALUE"]?>,
                groupid: <?=$arResult["DISPLAY_PROPERTIES"]["GROUPID"]["DISPLAY_VALUE"]?>,
                be: JSON.stringify(obj.be),
                notbe: JSON.stringify(obj.notbe),
                disease: JSON.stringify(obj.disease),
                adj: JSON.stringify(obj.adj),
                sub: <?
                if($arResult["DISPLAY_PROPERTIES"]["SUB"]["DISPLAY_VALUE"]):
                echo $arResult["DISPLAY_PROPERTIES"]["SUB"]["DISPLAY_VALUE"];
                else:
                echo '0';
                endif;
                ?>
            },
            method: 'POST',
            dataType: 'json',
            timeout: 30,
            async: true,
            processData: true,
            scriptsRunFirst: true,
            emulateOnload: true,
            start: true,
            cache: false,
            onsuccess: function (data) {
                console.log(data)
                if(data=="Success"){
                    Swal(
                        'Готово!',
                        'Журнал был отредактирован',
                        'success'
                    )
window.location = 'https://erperp.ru/journal.php'
                }
                    else{
                    Swal(
                        'Ошибка!',
                        data,
                        'warning'
                    )
                }
            }
        })
    }
    function setNotBe(check) {
        if(check.checked){
            check.parentNode.parentNode.className="active";
        }
    }
    function setFront(check) {
        if(check.checked){
            check.parentNode.parentNode.className="success";
        }
        else{
            check.parentNode.parentNode.className="active";
        }
    }
    function setDisease(check) {
        if(check.checked){
            check.parentNode.parentNode.className="warning";
        }
        else{
            check.parentNode.parentNode.className="active";
        }
    }
</script>
