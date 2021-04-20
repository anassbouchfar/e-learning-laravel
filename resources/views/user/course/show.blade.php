@extends('user.layouts.master2')

@section('pageTitle',$course->title)


@section('Headerscripts')
<script src="http://mozilla.github.io/pdf.js/build/pdf.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<meta name="_token" content="{{ csrf_token() }}">

@endsection


@section('content')
<div class="card">
  <div class="progress progress-xs">
    <div id="progressCourse" class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: {{$course->pivot->progression}}%">
    </div>
  </div>
  <div class="card-header">
    <h3 class="card-title">
      <span class="badge bg-secondary"><span id="prog">{{$course->pivot->progression}} </span> %</span>
    </h3>
    <div class="card-tools">
      <button id="prev" type="button" class="btn btn-tool" >
        <i class="fas fa-arrow-left"></i>
      </button>
      <button id="next" type="button" class="btn btn-tool" >
        <i class="fas fa-arrow-right"></i>
      </button>
      <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn bg-secondary btn-sm">
          <input type="radio" name="options" id="option_b1" autocomplete="off" checked=""> <span id="page_num"></span> 
        </label>
        <label class="btn bg-secondary btn-sm">
          <input type="radio" name="options" id="option_b2" autocomplete="off"> <span id="page_count"></span>
        </label>
      </div>
    </div>
  </div>
  <div class="card-body">
    <canvas id="the-canvas"></canvas>
  </div>
  <!-- /.card-body -->
  <div class="card-footer">
    <div class="card-tools">
      <button id="prev1" type="button" class="btn btn-tool" >
        <i class="fas fa-arrow-left"></i>
      </button>
      <button id="next1" type="button" class="btn btn-tool" >
        <i class="fas fa-arrow-right"></i>
      </button>
      <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn bg-secondary btn-sm">
          <input type="radio" name="options" id="option_b1" autocomplete="off" checked=""> <span id="page_num1"></span> 
        </label>
        <label class="btn bg-secondary btn-sm">
          <input type="radio" name="options" id="option_b2" autocomplete="off"> <span id="page_count1"></span>
        </label>
      </div>
    </div>
  </div>
  <!-- /.card-footer-->
</div>

@endsection




@section('Footerscripts')
<script>
  // If absolute URL from the remote server is provided, configure the CORS
// header on that server.
var url =null
@if($course->pdf_path)
        var url = '/cours/{{$course->pdf_path}}';
@endif

//var url = '/cours/Cours DW HILAL Partie 1 2021.pdf';

// Loaded via <script> tag, create shortcut to access PDF.js exports.
var pdfjsLib = window['pdfjs-dist/build/pdf'];

// The workerSrc property shall be specified.
pdfjsLib.GlobalWorkerOptions.workerSrc = 'http://mozilla.github.io/pdf.js/build/pdf.worker.js';

var pdfDoc = null,
    pageNum = {{$course->pivot->currentPage}},
    pageRendering = false,
    pageNumPending = null,
    scale = 1.5
    canvas = document.getElementById('the-canvas'),
    ctx = canvas.getContext('2d'),
    courseId = {{$course->id}};
/**
 * Get page info from document, resize canvas accordingly, and render page.
 * @param num Page number.
 */
function renderPage(num) {
  pageRendering = true;
  // Using promise to fetch the page
  pdfDoc.getPage(num).then(function(page) {
    var viewport = page.getViewport({scale: scale});
    canvas.height = viewport.height;
    canvas.width = viewport.width;

    // Render PDF page into canvas context
    var renderContext = {
      canvasContext: ctx,
      viewport: viewport
    };
    var renderTask = page.render(renderContext);

    // Wait for rendering to finish
    renderTask.promise.then(function() {
      pageRendering = false;
      if (pageNumPending !== null) {
        // New page rendering is pending
        renderPage(pageNumPending);
        pageNumPending = null;
      }
    });
  });

  // Update page counters
  document.getElementById('page_num').textContent = num;
  document.getElementById('page_num1').textContent = num;
}

/**
 * If another page rendering in progress, waits until the rendering is
 * finised. Otherwise, executes rendering immediately.
 */
function queueRenderPage(num) {
  if (pageRendering) {
    pageNumPending = num;
  } else {
    renderPage(num);
  }
}

/**
 * Displays previous page.
 */
function onPrevPage() {
  if (pageNum <= 1) {
    return;
  }
  pageNum--;
  
  queueRenderPage(pageNum);
  updateCurrentPageAndProgCourse()
}
document.getElementById('prev').addEventListener('click', onPrevPage);
document.getElementById('prev1').addEventListener('click', onPrevPage);
/**
 * Displays next page.
 */
function onNextPage() {
  if (pageNum >= pdfDoc.numPages) {
    return;
  }
  pageNum++;
  
  queueRenderPage(pageNum);
  updateCurrentPageAndProgCourse()
}
document.getElementById('next').addEventListener('click', onNextPage);
document.getElementById('next1').addEventListener('click', onNextPage);

function updateCurrentPageAndProgCourse(){
   prog = pageNum*100/allPages 
   $("#prog").text(prog.toFixed(0))
   $("#progressCourse").css("width",prog.toFixed(0)+"%")
    $.ajax({
    headers: {
      'X-CSRF-Token': $('meta[name="_token"]').attr('content')
    },
    method: "POST",
    url: "/updateCurrentPageAndProgCourse",
    data: {allPages:allPages, pageNum: pageNum, courseId: courseId }
  })
      .done(function( msg ="") {
          
        
      })
      .fail(function() {
        alert( "error" );
      })
}

$(document).ready(function(){

  
/*
*/

});
/*function updateProgressionCourse(){
  $.ajax({
    headers: {
      'X-CSRF-Token': $('meta[name="_token"]').attr('content')
    },
    method: "POST",
    url: "/updateProgressionCourse",
    data: { allPages:allPages,pageNum: pageNum, courseId: courseId }
  })
      .done(function( msg ="") {
        console.log(msg)
      })
      .fail(function() {
        alert( "error" );
      })
} */

/**
 * Asynchronously downloads PDF.
 */
var allPages=0
pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
  pdfDoc = pdfDoc_;
  document.getElementById('page_count').textContent = pdfDoc.numPages;
  allPages=pdfDoc.numPages
  document.getElementById('page_count1').textContent = pdfDoc.numPages;
  // Initial/first page rendering
  renderPage(pageNum);
});

</script>
@endsection