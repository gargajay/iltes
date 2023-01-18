// $(window).scroll(function () {
//   var sticky = $('header'),
//       scroll = $(window).scrollTop();
//   if (scroll >= 50) sticky.addClass('stickyHeader');
//   else sticky.removeClass('stickyHeader');
// });

// $(document).ready(function() {
//     $('#example').DataTable();
// } );

// $(document).ready(function() {
//     $('#example1').DataTable();
// } );


// $('#example').DataTable({
//   language: {
//     paginate: {
//       next: '<i class="fal fa-angle-right"></i>',
//       previous: '<i class="fal fa-angle-left"></i>'
//     }
//   }
// });

$(document).ready(function () {
  $("#sidebarCollapse").on("click", function () {
    $("#sidebar").toggleClass("active");
    $(".sidebar-overlay").toggleClass("active");
  });
  $(".sidebar-overlay").on("click", function () {
    $("#sidebar").removeClass("active");
    $(".sidebar-overlay").removeClass("active");
  });
});
$(window).scroll(function () {
  var sticky = $("header"),
    scroll = $(window).scrollTop();
  if (scroll >= 50) sticky.addClass("stickyHeader");
  else sticky.removeClass("stickyHeader");
});
// if ($("#metismenu")) {
//   $("#metismenu").metisMenu();
// }


function increaseValue() {
  var value = parseInt(document.getElementById('number').value, 10);
  value = isNaN(value) ? 0 : value;
  value++;
  document.getElementById('number').value = value;
}

function decreaseValue() {
  var value = parseInt(document.getElementById('number').value, 10);
  value = isNaN(value) ? 0 : value;
  value < 1 ? value = 1 : '';
  value--;
  document.getElementById('number').value = value;
}

// $(document).ready(function() {
//     var dataTable = $('#example1').dataTable();
//     $("#searchbox").keyup(function() {
//         dataTable.fnFilter(this.value);
//     });    
// });


(function($) {
  
  function createPdfPreview(fileContents, $displayElement) {
    PDFJS.getDocument(fileContents).then(function(pdf) {
      pdf.getPage(1).then(function(page) {
        var $previewContainer = $displayElement.find('.preview__thumb');
        var canvas = $previewContainer.find('canvas')[0];
        canvas.height = $previewContainer.innerHeight();
        canvas.width = $previewContainer.innerWidth();

        var viewport = page.getViewport(1);
        var scaleX = canvas.width / viewport.width;
        var scaleY = canvas.height / viewport.height;
        var scale = (scaleX < scaleY) ? scaleX : scaleY;
        var scaledViewport = page.getViewport(scale);

        var context = canvas.getContext('2d');
        var renderContext = {
          canvasContext: context,
          viewport: scaledViewport
        };
        page.render(renderContext);
      });
    });
  }
  
  
  
  
  
  function createPreview(file, fileContents) {
    var $previewElement = '';
    switch (file.type) {
      case 'image/png':
      case 'image/jpeg':
      case 'image/gif':
        $previewElement = $('<img src="' + fileContents + '" />');
        break;
      case 'video/mp4':
      case 'video/webm':
      case 'video/ogg':
        $previewElement = $('<video autoplay muted width="100%" height="100%"><source src="' + fileContents + '" type="' + file.type + '"></video>');
        break;
      case 'application/pdf':
        $previewElement = $('<canvas id="" width="100%" height="100%"></canvas>');
        break;
      default:
        break;
    }
    var $displayElement = $('<div class="preview">\
                               <div class="preview__thumb"></div>\
                               <span class="preview__name" title="' + file.name + '">' + file.name + '</span>\
                               <span class="preview__type" title="' + file.type + '">' + file.type + '</span>\
                             </div>');
    $displayElement.find('.preview__thumb').append($previewElement);
    $('.upload__files').append($displayElement);
    
    if (file.type === 'application/pdf') {
      createPdfPreview(fileContents, $displayElement);
    }
  }
  
  
  
  
  
  function fileInputChangeHandler(e) {
    var URL = window.URL || window.webkitURL;
    var fileList = e.target.files;
    
    if (fileList.length > 0) {
      $('.upload__files').html('');
      
      for (var i = 0; i < fileList.length; i++) {
        var file = fileList[i];
        var fileUrl = URL.createObjectURL(file);
        var image = document.getElementById('profile');
        createPreview(file, fileUrl);
      }
    }
  }
  
  
  
  
  
  $(document).ready(function() {
    $('input:file').on('change', fileInputChangeHandler);
  });
})(jQuery.noConflict());