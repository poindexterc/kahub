// Copyright (c) 2010 Ivan Vanderbyl
// Originally found at http://ivan.ly/ui
// 
// Permission is hereby granted, free of charge, to any person obtaining a copy
// of this software and associated documentation files (the "Software"), to deal
// in the Software without restriction, including without limitation the rights
// to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the Software is
// furnished to do so, subject to the following conditions:
// 
// The above copyright notice and this permission notice shall be included in
// all copies or substantial portions of the Software.
// 
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
// OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
// THE SOFTWARE.

(function( $ ){
  // Simple wrapper around jQuery animate to simplify animating progress from your app
  // Inputs: Progress as a percent, Callback
  // TODO: Add options and jQuery UI support.
  $.fn.animateProgress = function(progress, callback) {    
    return this.each(function() {
      $(this).animate({
        width: progress+'%'
      }, {
        duration: 1000, 
        
        // swing or linear
        easing: 'swing',

        // this gets called every step of the animation, and updates the label
        step: function( progress ){
          var labelEl = $('.ui-label'),
              valueEl = $('.value'),
			  notDone1 = $('.notDone1'),
			  notDone2 = $('.notDone2'),
			  notDone3 = $('.notDone3'),
			  done1 = $('.done1'),
			  done2 = $('.done2'),
			  done3 = $('.done3');
          
          if (Math.ceil(progress) < 20 && $('.ui-label', this).is(":visible")) {
            labelEl.hide();
          }else{
            if (labelEl.is(":hidden")) {
              labelEl.fadeIn();
            };
          }
		
          if (Math.ceil(progress) == 1) {
    		notDone1.hide();
    		done1.fadeIn();
			
		}
		
		
		  if (Math.ceil(progress) == 50) {
			notDone2.hide();
    		done2.fadeIn();
			}

		
		
          if (Math.ceil(progress) == 100) {
            notDone3.hide();
    		done3.fadeIn();
            setTimeout(function() {
              labelEl.fadeOut();
            }, 1000);
          }else{
            valueEl.text(Math.ceil(progress) + '%');
          }
        },
        complete: function(scope, i, elem) {
          if (callback) {
            callback.call(this, i, elem );
          };
        }
      });
    });
  };
})( jQuery );
  
$(function() {
  // Hide the label at start
  $('#progress_bar .ui-progress .ui-label').hide();
  // Set initial value
  $('#progress_bar .ui-progress').css('width', '0%');
	function stepOne(){
		$('#progress_bar .ui-progress').animateProgress(0);
	 }
	function stepTwo(){
		$('#progress_bar .ui-progress').animateProgress(50);
	 }
	function stepFinal(){
		$('#progress_bar .ui-progress').animateProgress(100);
	 }
  // Simulate some progres    $(this).animateProgress(79, function() 
  });
  
