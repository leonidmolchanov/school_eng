<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("student-card");
?>

    <div class="col-md-12 push">
        <div id="example-datatables2_wrapper" class="dataTables_wrapper form-inline no-footer">
            <div class="row">
                <div class="col-sm-6 col-xs-5">
                    <div class="dataTables_length" id="example-datatables2_length"><label><select
                                    name="example-datatables2_length" aria-controls="example-datatables2"
                                    class="form-control">
                                <option value="10">10</option>
                                <option value="25">25</option>
                            </select></label></div>
                </div>
                <div class="col-sm-6 col-xs-7">
                    <div id="example-datatables2_filter" class="dataTables_filter"><label>
                            <div class="input-group"><input type="search" class="form-control" placeholder="Поиск"
                                                            aria-controls="example-datatables2"><span
                                        class="input-group-addon"><i class="fa fa-search"></i></span></div>
                        </label></div>
                </div>
            </div>
            <table id="example-datatables2" class="table table-striped table-bordered table-hover dataTable no-footer"
                   role="grid" aria-describedby="example-datatables2_info">
            <thead>
                <tr role="row">
                    <th class="text-center sorting_asc" tabindex="0" aria-controls="example-datatables2" rowspan="1"
                        colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending"
                        style="width: 80px;">#
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="example-datatables2" rowspan="1" colspan="1"
                        aria-label=" Username: activate to sort column ascending" style="width: 269px;"><i
                                class="fa fa-user"></i> Номер договора
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="example-datatables2" rowspan="1" colspan="1"
                        aria-label=" Status: activate to sort column ascending" style="width: 347px;"><i
                                class="fa fa-bolt"></i> Фамилия Имя студента
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="example-datatables2" rowspan="1" colspan="1"
                        aria-label=" Status: activate to sort column ascending" style="width: 347px;"><i
                                class="fa fa-bolt"></i> Название Группы
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="example-datatables2" rowspan="1" colspan="1"
                        aria-label=" Status: activate to sort column ascending" style="width: 347px;"><i
                                class="fa fa-bolt"></i> Примечание
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="example-datatables2" rowspan="1" colspan="1"
                        aria-label=" Status: activate to sort column ascending" style="width: 347px;"><i
                                class="fa fa-bolt"></i> Статус абонента
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr role="row" class="odd">
                    <td class="text-center sorting_1">1</td>
                    <td><a href="javascript:void(0)">160</a></td>
                    <td><a href="javascript:void(0)">Иванов Иван</a></td>
                    <td><span class="label label-default">EX1</span></td>
                    <td><span class="label label-default">Дать скидку на всю жизнь</span></td>
                    <td><span class="label label-default">Оплачен до 22.12.2222</span></td>
                </tr></tbody>
            </table>
            <div class="row">
                <div class="col-sm-5 hidden-xs">
                    <div class="dataTables_info" id="example-datatables2_info" role="status" aria-live="polite"><strong>1</strong>-<strong>10</strong>
                        of <strong>30</strong></div>
                </div>
                <div class="col-sm-7 col-xs-12 clearfix">
                    <div class="dataTables_paginate paging_bootstrap" id="example-datatables2_paginate">
                        <ul class="pagination pagination-sm remove-margin">
                            <li class="prev disabled"><a href="javascript:void(0)"><i class="fa fa-chevron-left"></i>
                                </a></li>
                            <li class="active"><a href="javascript:void(0)">1</a></li>
                            <li><a href="javascript:void(0)">2</a></li>
                            <li><a href="javascript:void(0)">3</a></li>
                            <li class="next"><a href="javascript:void(0)"> <i class="fa fa-chevron-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 hidden-xs">
                    <div class="dataTables_info" id="example-datatables2_info" role="status" aria-live="polite"><strong>Итого (без учета со статусом "занимается"):</strong>
                </div>
                </div>
                    <div class="col-sm-4 hidden-xs">
                        <div class="dataTables_info" id="example-datatables2_info" role="status" aria-live="polite"><strong>Итого (всех студентов):</strong>
                        </div>
                    </div>
                        <div class="col-sm-4 hidden-xs">
                            <div class="dataTables_info" id="example-datatables2_info" role="status" aria-live="polite"><strong>Итого (со статусом заморожен или закончился):</strong>
                            </div>
                        </div>
            </div>

        </div>
        <div class="col-md-6 push text-center">

                <table id="example-datatables"
                       class="table table-striped table-bordered table-hover dataTable no-footer" role="grid"
                       aria-describedby="example-datatables_info">
                <thead>
                <tr role="row">
                    <th class="sorting" tabindex="0" aria-controls="example-datatables" rowspan="1" colspan="2"
                        aria-label=" Status: activate to sort column ascending" style="width: 324px;">Карточка студента
                    </th>
                </tr>
                </thead>
                    <tbody>
                    <tr role="row" class="odd">
                        <td><strong>Имя Фамилия студента</strong></td>
                        <td>Илья Попов</td>
                    </tr>
                    <tr role="row" class="odd">
                        <td><strong>Возраст студента</strong></td>
                        <td>8.08.2006 12 лет</td>
                    </tr>
                    <tr role="row" class="odd">
                        <td><strong>Номер договора</strong></td>
                        <td>160</td>
                    </tr>
                    <tr role="row" class="odd">
                        <td><strong>Имя Фамилия родителя (Мама)</strong></td>
                        <td>Попова Ирина</td>
                    </tr>
                    <tr role="row" class="odd">
                        <td><strong>Имя Фамилия родителя (Папа)</strong></td>
                        <td>Попов Павел </td>
                    </tr>
                    <tr role="row" class="odd">
                        <td><strong>Дата старта обучения</strong></td>
                        <td>1.1.2000</td>
                    </tr>
                   </tbody>
                </table>
        </div>
    </div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>