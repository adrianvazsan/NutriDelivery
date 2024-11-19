document.querySelectorAll('.watermarked').forEach(function(el) {
    el.dataset.watermark = (el.dataset.watermark + ' ').repeat(300);
  });