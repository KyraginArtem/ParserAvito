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
                            <h3>Отчет №{{$id}}</h3>
                            <div class="card-body">
                                <div class="container info">
                                    <label>Город:<br>
                                        <p>{{ $city }}</p>
                                    </label>

                                    <label>Наименование товара:
                                        <p>{{$productName}}</p>
                                    </label>

                                    <label>Тип рапорта:
                                        <p>{{$reportType}}</p>
                                    </label>

                                    <label>Дата запроса:
                                        <p>{{$reportDate}}</p>
                                    </label>
                                </div>

                                <div class="container info" >
                                    <form action="{{ route('wordSearch', $id) }}" method="GET">
                                        {!! csrf_field() !!}
                                        <label>Слова в описании<br/>
                                            <input type="text" name="wordSearch"><br>
                                        </label>
                                        <input type="submit" value="Найти" class="btn btn-success"><br/>
                                    </form>

                                    <form action="{{ route('export', $id) }}" method="GET">
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
                                @if(empty($ads))
                                    <tr><td>На момент запроса новых данных нет.</td></tr>
                                @else
                                    @foreach($ads as $item)
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
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



