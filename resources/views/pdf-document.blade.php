<!DOCTYPE html>
<html>
<head>
  <title>{{$document->name}}</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-12" style="margin-top: 15px ">
        <div class="pull-left">
          <h2>{{$document->name}}</h2>
        </div>
      </div>
    </div>
    <hr>
    @forelse($document->columns as $column)
    <div class="row">
      <div class="col-lg-12" style="margin-top: 15px ">
        <div class="pull-left">
          <h2>{{$column->name}}</h2>
          <p class="text-center">{{$column->pivot->content}}</p>
        </div>
      </div>
    </div>
    @empty
        <h4>no content to display</h4>
    @endforelse
  </div>
</body>
</html>