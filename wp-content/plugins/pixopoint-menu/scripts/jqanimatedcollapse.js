// Animated Collapsible DIV - Author: Will Anderson (http://www.itsananderson.com/)
// Created 7/19/09

/*
 * animatedcollapse: constructor for animated collapse class.
 * arguments:
 * divId - ID of div to expand/collapse
 * animateTime - time for expand/collapse action
 */
function animatedcollapse(divId, animateTime){
    this.divObject = jQuery('#' + divId);
    this.divObject.css('overflow', 'hidden');
    this.animateTime = animateTime;
    this.divObject.slideUp(0);
}

animatedcollapse.prototype.slideit=function(){
    this.divObject.slideToggle(this.animateTime);
}
