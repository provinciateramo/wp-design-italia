import Bricklayer from 'bricklayer/dist/bricklayer.min';

export default {
  init() {

    // JavaScript to be fired on all pages

      $(window).on("scroll touchmove",function(){
        $("#mainheader").toggleClass("ridotto",$(document).scrollTop()>0);
        $("body").toggleClass("ridotto",$(document).scrollTop()>0);
      });

      var current_search_section = 0;
      function change_search_section(advanced) {
        if (advanced === undefined) {
          advanced = current_search_section;
        }
        if (advanced==1) {
          $("#searchModal .ricerca_sezione_filtri").show();
          $("#searchModal .ricerca_sezione_generale").hide();
          current_search_section = 1;
        }
        else {
          $("#searchModal .ricerca_sezione_filtri").hide();
          $("#searchModal .ricerca_sezione_generale").show();
          current_search_section = 0;
        }
      }
      $('#bBackBaseSearchSm,#bBackBaseSearchMd').click(function() {change_search_section(0)})

      $('#searchModal').on('show.bs.modal', function () {
        change_search_section(0);
      })

      $('#attiva_filtri').click(function() {change_search_section(1)});

      $("div.cb-main input[type='checkbox']").click(function() {
        $(this).parents('.col').find(':not(div.cb-main) input[type=\'checkbox\']').prop("checked",$(this).is(':checked'));
      });
      //var bricklayer = null;
      var bricklayerEl = document.querySelector('.bricklayer');
      if (bricklayerEl)
        new Bricklayer(document.querySelector('.bricklayer'));


  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
