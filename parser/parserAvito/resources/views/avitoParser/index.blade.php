@extends('avitoParser.layout')
@section('content')
    <div class="container">
        <div class="row" style="margin:20px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{url('/avitoParser')}}" style="color: black"><h2>ParserAvito</h2></a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <div class="card-body">
                                <form action="{{url('/avitoParser')}}" method="post">
                                    {!! csrf_field() !!}
                                    <div class="container">
                                        <label>Город
                                        <select name="citiesName">
                                            @foreach($citiesName as $city)
                                                <option value="{{ $city->city_name }}">{{ $city->city_name }}</option>
                                            @endforeach
                                        </select></label>

                                        <label>Наименование товара
                                        <select name="productsName">
                                            @foreach($productsName as $good)
                                                <option value="{{ $good->product_name }}">{{ $good->product_name }}</option>
                                            @endforeach
                                        </select></label>

                                        <label>Тип рапорта
                                        <select name="reportTypes">
                                            @foreach($reportTypes as $reportType)
                                                <option value="{{ $reportType->report_name }}">{{ $reportType->report_name }}</option>
                                            @endforeach
                                        </select></label>

                                        <label>На базе отчета №

                                        <input type="number" name="reportNumberBase">
                                            @if(Session::has('message'))
                                                <div class="alert alert-info">
                                                    {{ Session::get('message') }}
                                                </div>
                                            @endif
                                        </label>
                                    </div>
                                    <input type="submit" value="Создать новый рапорт" class="btn btn-success"
                                    style="margin-left: 20px">
                                </form>
                            </div>

                            <table class="table">
                                <thead>
                                <tr>
                                    <th>№ отчета</th>
                                    <th>Наименование товара</th>
                                    <th>Тип отчета</th>
                                    <th>Город</th>
                                    <th>Дата запроса</th>
                                    <th>На базе отчета №</th>
                                    <th>Состояние отчета</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($reports as $item)
                                    <tr class="{{ $item['report_status_id'] === 1 ? 'muted' : '' }}">
                                        <td>{{$item['id']}}</td>

                                        @foreach($productsName as $prodName)
                                            @if($prodName['id'] === $item['product_name_id'])
                                                <td style="text-align: center">{{$prodName['product_name']}}</td>
                                            @endif
                                        @endforeach

                                        @foreach($reportTypes as $typeName)
                                            @if($typeName['id'] === $item['report_type_id'])
                                                <td>{{$typeName['report_name']}}</td>
                                            @endif
                                        @endforeach

                                        @foreach($citiesName as $cityName)
                                            @if($cityName['id'] === $item['city_name_id'])
                                                <td>{{$cityName['city_name']}}</td>
                                            @endif
                                        @endforeach

                                        <td>{{$item['date_request']}}</td>

                                        <td style="text-align: center">{{$item['report_in_base']}}</td>

                                        @foreach($reportStatuses as $statusName)
                                            @if($statusName['id'] === $item['report_status_id'])
                                                <td style="text-align: center">{{$statusName['status_name']}}</td>
                                            @endif
                                        @endforeach
                                        <td>
                                            <a href="{{url('/avitoParser/'. $item['id'])}}"
                                               class="{{ $item['report_status_id'] === 1 ? 'unclickable' : 'clickable' }}"
                                               title="View message"><button class="btn btn-info btn-sm ">View</button>
                                            </a>
                                            <form action="{{url('/avitoParser' . '/' . $item['id'])}}" method="POST"
                                                  accept-charset="UTF-8" style="display: inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}

                                                <button type="submit" title="Delete message" class="btn btn-danger btn-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


