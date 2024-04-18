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
                            <h3>Отчет №{{$report['report_id']}}, поиск объявлений с словами "{{$wordSearch}}" в описании.</h3>
                            <div class="card-body">

                                <div class="container info">
                                    <label>Город:
                                        <p>{{ $report['city_name'] }}</p>
                                    </label>

                                    <label>Наименование товара:
                                        <p>{{$report['product_name']}}</p>
                                    </label>

                                    <label>Тип рапорта:
                                        <p>{{$report['report_type']}}</p>
                                    </label>

                                    <label>Дата запроса:
                                        <p>{{$report['date_request']}}</p>
                                    </label>
                                </div>

                                <div class="container info">
                                    <form action="{{ route('wordSearch', $report['report_id']) }}" method="GET">
                                        {!! csrf_field() !!}
                                        <label>Слова в описании<br/>
                                            <input type="text" name="wordSearch"><br>
                                        </label>
                                        <input type="submit" value="Найти" class="btn btn-success">
                                    </form>

                                    <form action="{{ route('export', $report['report_id']) }}" method="GET">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Создать файл</button>
                                    </form>
                                </div>


                            </div>

                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Ссылка</th>
                                    <th>Описание</th>
                                    <th>Цена</th>
                                    <th>Состояние объявления</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($foundAds as $item)
                                    <tr>
                                        <td>{{$item['title']}}</td>
                                        <td><a href="{{$item['link']}}">Ссылка</a></td>

                                        <td>{{$item['description']}}</td>

                                        <td>{{$item['price']}}</td>
                                        <td>
                                            @if($item['status_name_id'] === 1)
                                                Активное
                                            @else
                                                Снято с продажи
                                            @endif
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
