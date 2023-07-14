function back(){
    window.history.back(-1);
}
/**判断屏幕大小 */
function	judgeBigScreen() {  //，这里根据返回值 true 或false ,返回true的话 则为全面屏 
	let result = false;
		const rate = window.screen.height / window.screen.width;    
		let limit =  window.screen.height == window.screen.availHeight ? 1.8 : 1.6; // 临界判断值  
		    
   // window.screen.height为屏幕高度
  //  window.screen.availHeight 为浏览器 可用高度
  
		if (rate > limit) {
		result = true;
		}
		return result;
	};
   
	//自动执行匿名函数
(function() {
	$().ready(function() {
        judgeBigScreen();//判断手机是否为全面屏
	});
})();