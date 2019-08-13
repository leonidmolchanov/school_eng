<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("student-card");
global $USER;
$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();
$schoolID =  $arUser['UF_SCHOOL_ID'];
$teacher=[];


?>
    <div id="example-datatables_wrapper" class="">
        <table id="user_table" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="example-datatables2_info">
            <thead>
            <tr role="row">
                <th rowspan="1" colspan="1" class="text-center sorting_asc" tabindex="0" aria-controls="example-datatables2" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 80px;">
                    #
                </th>
                <th rowspan="1" colspan="1" class="sorting" tabindex="0" aria-controls="example-datatables2" aria-label=" Status: activate to sort column ascending" style="width: 347px;">
                    Фамилия Имя студента
                </th>
                <th rowspan="1" colspan="1" class="sorting" tabindex="0" aria-controls="example-datatables2" aria-label=" Status: activate to sort column ascending" style="width: 347px;">
                    Тип
                </th>
            </tr>
            </thead>
            <tbody>
            <? $number=1;?>
            <?
            if (CModule::IncludeModule("iblock")):
    # show url my elements
    $my_elements = CIBlockElement::GetList (
        Array("ID" => "ASC"),
        Array("IBLOCK_CODE" => Array(0=>'TEACHER',
            1=>'METHODIST',
            2=>'ADMINISTRATOR'),
            'PROPERTY_SCHOOL_ID'=>$schoolID),
        false,
        false,
        Array('ID', 'NAME', 'DETAIL_PAGE_URL','PROPERTY_NAME','PROPERTY_LAST_NAME')
    );

    while($ar_fields = $my_elements->GetNext())
    {
        ?>
      <tr role="row" class="odd success"
                >
                    <td class="text-center sorting_1">
                        <?=$number;?>
                    </td>
                    <td>
                        <a href="
                        <? if($ar_fields["IBLOCK_CODE"]=='TEACHER'):
                            ?>/teacher-card.php?ELEMENT_ID=<?=$ar_fields["ID"]?><?
                        elseif($ar_fields["IBLOCK_CODE"]=='METHODIST'):
                            ?>/methodist-card.php?ELEMENT_ID=<?=$ar_fields["ID"]?><?

                        elseif($ar_fields["IBLOCK_CODE"]=='ADMINISTRATOR'):
                            ?>/administrator-card.php?ELEMENT_ID=<?=$ar_fields["ID"]?><?


                        endif;?>
"><?=$ar_fields["PROPERTY_NAME_VALUE"]?> <?=$ar_fields["PROPERTY_LAST_NAME_VALUE"]?></a>
                    </td>
          <td>
              <?
              if($ar_fields["IBLOCK_CODE"]=='TEACHER'):
?>Учитель<?
                  elseif($ar_fields["IBLOCK_CODE"]=='METHODIST'):
                      ?>Методист<?

              elseif($ar_fields["IBLOCK_CODE"]=='ADMINISTRATOR'):
                  ?>Администратор<?


                  endif;

              ?>
          </td>
                </tr>

            <?
        $number++;

    }
endif;
    ?>
            </tbody>
        </table>

    </div>
    <script>
        BX.ready(function() {
            $(function () {
                /* Initialize Datatables */
                $('#user_table').dataTable({columnDefs: [{orderable: false, targets: [0]}]});
                $('.dataTables_filter input').attr('placeholder', 'Поиск');
            });
        });

        document.querySelector('#filter_checkbox').addEventListener('click', function (evt) {
            elem =  $('#user_table tbody tr')
            console.log(elem)


        })
    </script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>