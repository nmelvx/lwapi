@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ $data['title'] }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Tags</th>
                        <th class="text-right">Actions</th>
                    </tr>
                    @if(!$items->isEmpty())
                    @foreach($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title }}</td>
                        <td>@if(isset($item->category->name)){{ $item->category->name }}@endif</td>
                        <td>@if(isset($item->type->name)){{ $item->type->name }}@endif</td>
                        <td>
                            @if(sizeof($item->tags) > 0)
                                @foreach($item->tags as $k => $tag)
                                    {{$tag->tag}}{{ ($k+1 < sizeof($item->tags))?', ':'' }}
                                @endforeach
                            @endif
                        </td>

                        <td class="text-right">
                            {!! Form::open(['method' => 'DELETE', 'route' => ['lw.destroy', $item->id], 'class' => 'delete-form']) !!}
                                {!! link_to_route('lw.edit', 'Edit', $item->id, ['class' => 'btn btn-xs bg-blue'])  !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-xs bg-red']) !!}
                            {!! Form::close() !!}

                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="4">No data available</td>
                    </tr>
                    @endif
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection