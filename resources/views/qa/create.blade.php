<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>TeacherBot BINUS x UT ICE</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="m-4">
<p class="h3 text-center">TeacherBot : Question & Answer Generator</p>
</div>
<div class="m-4">
    <form action="{{ url('/generates') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
      <div class="border p-4">
          <div class="form-group">
            <select class="form-select" aria-label="select courses" id="Courses" name="courses">
            <option value="0">Select Courses</option>
            @foreach ($courses as $key=>$course)
            <option value="{{$course->id}}">{{$course->name}}</option>
            @endforeach
            </select>
          </div>
          <div class="form-group "> <br></div>
          <div class="form-group">
              <textarea class="form-control" id="SourceText" name="sourceText" placeholder="Input your sentences or paragraf here..." ></textarea>
          </div>
          <div class="form-group "> Or</div>
          <div class="form-group w-25 ">
              <label class="visually-hidden" for="SourceFile">Source File</label>
              <input type="file" class="form-control" id="SourceFile" name="sourceFile">
              <span class="text-danger">{{ $errors->first('sourceFile') }}</span>
          </div>
          <div class="form-group "><br></div>
          <div class="form-group ">
              <button type="submit" class="btn btn-primary">Generate</button>
          </div>
      </div>
    </form>
</div>
<div class="m-4">
  <table class="table table-success table-striped">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Source</th>
      <th scope="col">Question</th>
      <th scope="col">Answer</th>
    </tr>
  </thead>
  <tbody>
  @if(isset($data))
  <?php $no = 1; ?>
  @foreach ($data as $item)
    <tr>
      <th scope="row">{{ $no }}</th>
      <td>{{ $item['source'] }}</td>
      <td>{{ $item['questions'] }}</td>
      <td>{{ $item['answer'] }}</td>
    </tr>
  <?php $no++; ?>
  @endforeach
  @else
    <tr>
      <th scope="row" colspan="4">Data is not available</th>
    </tr>
  @endif 
  </tbody>
</table>
</div>
</body>
</html>