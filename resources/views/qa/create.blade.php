<form action="{{ url('/generates') }}" method="POST" enctype="multipart/form-data">
{{ csrf_field() }}
  <div class="mb-3">
    <label for="SourceText" class="form-label">Source Text</label>
    <textarea class="form-control" id="sourceText" name="sourceText" ></textarea>
    <div id="or" class="form-text">Or</div>
  </div>
  <div class="mb-3">
    <label for="SourceFile" class="form-label">Source File</label>
    <input type="file" class="form-control" id="sourceFile" name="sourceFile">
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>