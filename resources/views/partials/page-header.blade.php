<section class="content-header">
    <h1>
        {{ $data['title'] }}
        <small>{{ $data['type'] }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">{{ $data['title'] }}</li>
    </ol>
</section>
