<?php
function dich($lang,$str)
{
	$kq=$str;
	if($lang=='vi')
	{
        if($str=='home')
        {
            $kq='Trang chủ';
        }
        if($str=='address')
        {
            $kq='Địa chỉ';
        }	
        if($str=='hotline')
        {
            $kq='Hotline';
        }   
        if($str=='copyright')
        {
            $kq='Bản quyền 2014';
        }
        if($str=='masothue')
        {
            $kq='Mã số thuế';
        }
        if($str=='sotaikhoan')
        {
            $kq='Số tài khoản';
        }
        if($str=='phone')
        {
            $kq='Điện thoại';
        }
        if($str=='email')
        {
            $kq='Email';
        }
        if($str=='design')
        {
            $kq='Thiết kế website';
        }
        if($str=='contact')
        {
            $kq='Liên hệ';
        }
        if($str=='hoten')
        {
            $kq='Họ tên';
        }
        if($str=='content')
        {
            $kq='Nội dung';
        }
        if($str=='send')
        {
            $kq='Gửi';
        }
        if($str=='reset')
        {
            $kq='Làm lại';
        }
        if($str=='support')
        {
            $kq='Hỗ trợ trực tuyến';
        }
        if($str=='dataupdate')
        {
            $kq='Dữ liệu đang cập nhật';
        }
        if($str=='ngaydang')
        {
            $kq='Ngày đăng';
        }
        if($str=='view')
        {
            $kq='Lượt xem';
        }
        if($str=='chiase')
        {
            $kq='Chia sẻ';
        }
        if($str=='tukhoa')
        {
            $kq='Từ khóa';
        }
        if($str=='tinxemnhieu')
        {
            $kq='Tin xem nhiều';
        }
        if($str=='tinmoi')
        {
            $kq='Tin mới';
        }
        if($str=='tinlienquan')
        {
            $kq='Tin liên quan';
        }
        if($str=='chitiet')
        {
            $kq='Chi tiết';
        }
        if($str=='xemtatca')
        {
            $kq='Xem tất cả';
        }
        if($str=='danhmucsp')
        {
            $kq='Danh mục';
        }
        if($str=='doitac')
        {
            $kq='Đối tác';
        }
        if($str=='gia')
        {
            $kq='Giá';
        }
        if($str=='sanphamnoibat')
        {
            $kq='Sản phẩm nổi bật';
        }
        if($str=='sanphamcungloai')
        {
            $kq='Sản Phẩm cùng loại';
        }
        if($str=='dathang')
        {
            $kq='Đặt hàng';
        }
        if($str=='tinhtrang')
        {
            $kq='Tình trạng';
        }
        if($str=='mota')
        {
            $kg='Mô tả';
        }
        if($str=='sanphamchitiet')
        {
            $kq='Sản phẩm chi tiết';
        }
        if($str=='sanpham')
        {
            $kq='Sản phẩm';
        }
        if($str=='moitt')
        {
            $kq='Mọi thông tin liên hệ';
        }  
        if($str=='timkiemleft')
        {
            $kq='Tìm kiếm';
        }    
        if($str=='loaispleft')
        {
            $kq='Loại sản phẩm';
        } 
        if($str=='chungloaileft')
        {
            $kq='Chủng loại';
        } 
        if($str=='thongketc')
        {
            $kq='Thống kê truy cập';
        }
        if($str=='onlinetk')
        {
            $kq='Đang online';
        }
        if($str=='todaytk')
        {
            $kq='Hôm nay';
        }
        if($str=='monthtk')
        {
            $kq='Tháng này';
        }
        if($str=='luottk')
        {
            $kq='Lượt truy cập';
        }
        if($str=='hinhanhhd')
        {
            $kq='Hình ảnh hoạt động';
        }
        if($str=='thuvienanh')
        {
            $kq='Thư viện ảnh';
        }
	}    
    if($lang=='en')
	{	
	   if($str=='home')
       {
            $kq='Home';
       }	
       if($str=='address')
       {
            $kq='Address';
       }  
       if($str=='hotline')
       {
            $kq='Hotline';
       } 
       if($str=='copyright')
       {
            $kq='Copyright 2014';
       }   
       if($str=='masothue')
       {
            $kq='Tax Code';
       }  
       if($str=='sotaikhoan')
       {
            $kq='Account Number';
       }  
       if($str=='phone')
       {
            $kq='Phone';
       } 
       if($str=='email')
       {
            $kq='Email';
       }
       if($str=='design')
       {
            $kq='Web Design';
       }
       if($str=='contact')
       {
            $kq='Contact Us';
       }
       if($str=='hoten')
       {
            $kq='Fullname';
       }
       if($str=='content')
       {
            $kq='Content';
       }
       if($str=='send')
       {
            $kq='Send';
       }
       if($str=='reset')
       {
            $kq='Reset';
       }
       if($str=='support')
       {
            $kq='Support Online';
       }
       if($str=='dataupdate')
       {
            $kq='Data is updated';
       }
       if($str=='ngaydang')
       {
            $kq='Date';
       }
       if($str=='view')
       {
            $kq='View';
       }
       if($str=='chiase')
       {
            $kq='Share';
       }
       if($str=='tukhoa')
       {
            $kq='Keywords';
       }
       if($str=='tinxemnhieu')
       {
            $kq='See more news';
       }
       if($str=='tinmoi')
       {
            $kq='Last New';
       }
       if($str=='tinlienquan')
       {
            $kq='Related news';
       }
       if($str=='chitiet')
       {
            $kq='Read more';
       }
       if($str=='xemtatca')
       {
            $kq='View all';
       }
       if($str=='danhmucsp')
       {
            $kq='Product';
       }
       if($str=='doitac')
       {
            $kq='Partners';
       }
       if($str=='gia')
       {
            $kq='Price';
       }
       if($str=='sanphamnoibat')
       {
            $kq='Hot Products';
       }
       if($str=='sanphamcungloai')
       {
            $kq='Prodcuts';
       }
       if($str=='dathang')
       {
            $kq='Order';
       }
       if($str=='tinhtrang')
       {
            $kq='Status';
       }
       if($str=='mota')
       {
            $kq='Description';
       }
       if($str=='sanphamchitiet')
       {
            $kq='Product details';
       }
       if($str=='sanpham')
       {
            $kq='Products';
       }
       if($str=='moitt')
       {
            $kq='For further information contact';
       }  
       if($str=='timkiemleft')
       {
            $kq='Search';
       }  
       if($str=='loaispleft')
       {
            $kq='Type of product';
       } 
       if($str=='chungloaileft')
       {
            $kq='Categories';
       }   
       if($str=='thongketc')
        {
            $kq='Visitor Statistics';
        } 
        if($str=='onlinetk')
        {
            $kq='Online';
        }
        if($str=='todaytk')
        {
            $kq='Today';
        }
        if($str=='monthtk')
        {
            $kq='Month';
        }
        if($str=='luottk')
        {
            $kq='Visit';
        } 
        if($str=='hinhanhhd')
        {
            $kq='Pictures of activities';
        }
        if($str=='thuvienanh')
        {
            $kq='Photo Gallery';
        }       
	}
   	/*
    if($lang=='cn')
    {
        if($str=='home')
        {
            $kq='家';
        }
        if($str=='address')
        {
            $kq='地址';
        }
        if($str=='hotline')
        {
            $kq='热线';
        }
        if($str=='copyright')
        {
            $kq='版权所有 2014';
        }
        if($str=='masothue')
        {
            $kq='税法';
        }	
        if($str=='sotaikhoan')
        {
            $kq='帐号';
        } 
        if($str=='phone')
        {
            $kq='电话号码';
        }
        if($str=='email')
        {
            $kq='电子邮件';
        }
        if($str=='design')
        {
            $kq='网页设计';
        }
        if($str=='contact')
        {
            $kq='他留置权';
        }
        if($str=='hoten')
        {
            $kq='他们的名字';
        }
        if($str=='content')
        {
            $kq='内容';
        }
        if($str=='send')
        {
            $kq='发送';
        }
        if($str=='reset')
        {
            $kq='重做';
        }
        if($str=='support')
        {
            $kq='在线支持';
        }
        if($str=='dataupdate')
        {
            $kq='数据更新';
        }
        if($str=='ngaydang')
        {
            $kq='日期';
        }
        if($str=='view')
        {
            $kq='浏览次数';
        }
        if($str=='chiase')
        {
            $kq='共享';
        }
        if($str=='tukhoa')
        {
            $kq='关键词';
        }
        if($str=='tinxemnhieu')
        {
            $kq='查看更多新闻';
        }
        if($str=='tinmoi')
        {
            $kq='新闻';
        }
        if($str=='chitiet')
        {
            $kq='详细信息';
        }
        if($str=='tinlienquan')
        {
            $kq='相关新闻';
        }
        if($str=='xemtatca')
        {
            $kq='查看全部';
        }
        if($str=='danhmucsp')
        {
            $kq='产品目录';
        }
        if($str=='doitac')
        {
            $kq='合作伙伴';
        }
        if($str=='gia')
        {
            $kq='价格';
        }
        if($str=='sanphamnoibat')
        {
            $kq='热门产品';
        }
        if($str=='dathang')
        {
            $kq='顺序';
        }
        if($str=='sanphamcungloai')
        {
            $kq='产品展示';
        }
        if($str=='tinhtrang')
        {
            $kq='状态';
        }
        if($str=='mota')
        {
            $kq='描述';
        }
        if($str=='sanphamchitiet')
        {
            $kq='产品详情';
        }
        if($str=='sanpham')
        {
            $kq='产品展示';
        }
        if($str=='moitt')
        {
            $kq='欲了解更多信息，请联系';
        }
        if($str=='timkiemleft')
        {
            $kq='搜索';
        }     
        if($str=='loaispleft')
        {
            $kq='产品类型';
        } 
        if($str=='chungloaileft')
        {
            $kq='分类';
        }      
	}*/
	return $kq;	
}
?>