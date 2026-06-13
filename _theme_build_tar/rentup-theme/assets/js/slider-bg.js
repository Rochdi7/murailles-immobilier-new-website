(function($) {
  $(document).ready(function() {
    if ($('[data-background]').length > 0) {
      $('[data-background]').each(function() {
        var $background, $backgroundmobile, $this, canUseMobileBackground;
        $this = $(this);
        $background = $(this).attr('data-background');
        $backgroundmobile = $(this).attr('data-background-mobile');
        canUseMobileBackground = window.device && typeof window.device.mobile === 'function' && window.device.mobile();

        if (!$background) {
          return;
        }

        if ($background.substr(0, 1) === '#') {
          return $this.css('background-color', $background);
        } else if ($backgroundmobile && canUseMobileBackground) {
          return $this.css('background-image', 'url(' + $backgroundmobile + ')');
        } else {
          return $this.css('background-image', 'url(' + $background + ')');
        }
      });
    }
  });
})(jQuery);
