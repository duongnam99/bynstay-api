<!DOCTYPE html>
<html>
<head>
 <title>Thông báo đặt chỗ thành công</title>
</head>
<body>
 
 <h1>Bạn đã đặt chỗ thành công!</h1>

 <div><span>Mã đặt chỗ:</span><h2> {{$order->success_code}}</h2></div> 
 <small>Vui lòng bảo mật thông tin mã code - Mã code sẽ dùng để đối chiếu với chủ nơi nghỉ dưỡng</small>
<p>Vui lòng truy cập: <a href="{{$myOrder}}" target="_blank">Đơn đặt chỗ của tôi</a> để xem thông tin chi tiết</p>
 <p>Bynstay xin cảm ơn!</p>
 
</body>
</html> 