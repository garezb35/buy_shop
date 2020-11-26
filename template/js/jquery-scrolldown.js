$(document).ready(
	function() {
	var $doc           = $(document);
	var position       = 0;
	var top = $doc.scrollTop(); //현재 스크롤바 위치
	var screenSize     = 0;        // 화면크기
	var halfScreenSize = 0;    // 화면의 반

	/*사용자 설정 값 시작*/
	var pageWidth      = 1100; // 페이지 폭, 단위:px
	var leftOffet      = -665;  // 중앙에서의 폭(왼쪽 -, 오른쪽 +), 단위:px
	var leftMargin     = 1000; // 페이지 폭보다 화면이 작을때 옵셋, 단위:px, leftOffet과 pageWidth의 반만큼 차이가 난다.
	var speed          = 0;     // 따라다닐 속도 : "slow", "normal", or "fast" or numeric(단위:msec)
	var easing         = 'swing'; // 따라다니는 방법 기본 두가지 linear, swing
	var $layer         = $('#floating2'); // 레이어 셀렉팅
	var $layer2        = $('#floating'); 
	var $layer3        = $('#floating3'); 
	$layer.css('z-index', 10);   // 레이어 z-인덱스
	/*사용자 설정 값 끝*/

	//좌우 값을 설정하기 위한 함수
	function resetXPosition() {
		$screenSize = $('body').width();// 화면크기
		halfScreenSize = $screenSize/2;// 화면의 반
		xPosition = halfScreenSize + leftOffet;
		if ($screenSize < pageWidth)
			xPosition = leftMargin;

		$layer.css('left', xPosition);
	}

	// 스크롤 바를 내린 상태에서 리프레시 했을 경우를 위해
	if (top > 0 )
		$doc.scrollTop(layerTopOffset+top);
	else
		$doc.scrollTop(0);

	// 최초 레이어가 있을 자리 세팅
	$layer.css('top',layerTopOffset);
	$layer2.css('top',layerTopOffset);
	$layer3.css('top',50); 
	$layer3.css('right',-150); 
	resetXPosition();

	//윈도우 크기 변경 이벤트가 발생하면
	$(window).resize(resetXPosition);

	//스크롤이벤트가 발생하면
	$(window).scroll( function() {
		yPosition = $doc.scrollTop()+layerTopOffset;
		$layer.animate({"top":yPosition }, {duration:speed, easing:easing, queue:false});
		$layer2.animate({"top":yPosition }, {duration:speed, easing:easing, queue:false});
		if($(window).scrollTop()>600){
			$layer3.animate({"top":$doc.scrollTop() -500 }, {duration:speed, easing:easing, queue:false});
		}
		else{
			$layer3.animate({"top":0 }, {duration:speed, easing:easing, queue:false});
		}
		
	});
});