@extends('layouts.index')

@section('content')
<section>
	<div class="container">
		<div class="row header-inner">
			<div class="col-lg-12">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="{{route('index')}}"> <i class="fas fa-home"></i>Trang chủ </a></li>
                    <li>
                        <span class="space">/</span>
                    </li>
                    <li class="breadcrumb-item active"><span>Lãi xuất</span></li>
				</ol>
			</div>
		</div>
	</div>
</section>
<section class="space-ptb">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
                <h2>
                    Swift Code là gì? Tổng hợp mã Swift Code các ngân hàng tại Việt Nam
                </h2>
                    <img src="{{asset('images/swift-code.png')}}" alt="Swift Code là gì? Tổng hợp mã Swift Code các ngân hàng tại Việt Nam" style="max-width: 100%; margin: 20px 0px">
                <h3>
                    Swift Code là gì?
                </h3>
                <p>
                    Swift là từ viết tắt của cụm từ Society for Worldwide Interbank Financial Telecommunication – Hiệp hội Viễn thông Tài chính Ngân hàng toàn cầu. Hiệp hội này giúp kết nối các ngân hàng với nhau thông qua thực hiện các giao dịch ( chuyển/nhận) tiền quốc tế một cách dễ dàng, tiết kiệm chi phí và độ bảo mật cao. Code được hiểu là một dãy các kí tự gồm các chữ hoặc số tạo nên các mã riêng biệt.
                </p>
                <p>
                    Swift Code còn được gọi là BIC (Business Identifier Codes ) thực chất là một mã định danh, giúp bạn nhận diện vị trí bất cứ ngân hàng hoặc tổ chức tài chính nào đó thuộc mọi quốc gia trên thế giới. Thông thường, mã Swift Code cần được cung cấp khi thực hiện giao dịch nước ngoài.
                </p>
                <p>
                    Mã Swift Code thường có 8 ký tự hoặc 11 ký tự, mỗi ký tự mang ý nghĩa riêng về : tên ngân hàng, tên quốc gia, mã chi nhánh.

                </p>
                <h3>Swift Code dùng làm gì?</h3>
                <p>
                    Swift Code là yêu cầu cơ bản mà khi nhận/chuyển tiền từ quốc tế về Việt Nam không thể thiếu. Như đã biết thông tin ở trên, Swift Code giúp thống nhất các thông tin trên toàn cầu dễ dàng biết được ngân hàng bạn có tên chính xác là gì, ở nước nào nào, đang đăng ký chi nhánh nào, địa chỉ cụ thể là ở đâu?
                </p>
                <p>
                    Tại Việt Nam, đa số các ngân hàng thường sử dụng Swift Code loại 8 ký tự là phổ biến nhất. Bởi vì loại 11 ký tự có thêm mã chi nhánh, mà tại Việt Nam một ngân hàng thì có rất rất nhiều chi nhánh. Do đó các ngân hàng thường đưa Swift Code 8 ký tự trên website của họ như bảng dưới đây.
                </p>
                <h3>
                    Bảng mã Swift Code của các ngân hàng tại Việt Nam
                </h3>
                <table class="swift-code">
                    <tbody>
                        <tr>
                            <td><strong>Tên viết tắt</strong></td>
                            <td><strong>Tên ngân hàng</strong></td>
                            <td><strong>Tên Tiếng Anh</strong></td>
                            <td><strong>&nbsp;Swift Code</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Agribank</strong></td>
                            <td>Ngân hàng Nông nghiệp và phát triển nông thôn</td>
                            <td>Vietnam Bank for&nbsp;Agriculture and Rural Development</td>
                            <td>VBAAVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>ACB</strong></td>
                            <td>Ngân hàng Á Châu</td>
                            <td>Asia Commercial Bank</td>
                            <td>ASCBVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>ANZ</strong></td>
                            <td>Ngân hàng TNHH 1 thành viên ANZ</td>
                            <td>Australia and New Zealand Banking Group</td>
                            <td>ANZBVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>ABBank</strong></td>
                            <td>Ngân hàng An Bình</td>
                            <td>An Binh Commercial Joint Stock Bank</td>
                            <td>ABBKVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>Bảo Việt Bank</strong></td>
                            <td>Ngân hàng Bảo Việt</td>
                            <td>Baoviet Bank</td>
                            <td>BVBVVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>Bắc Á Bank</strong></td>
                            <td>Ngân hàng Bắc Á</td>
                            <td>North Asia Commercial Joint Stock Bank</td>
                            <td>NASCVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>BIDV</strong></td>
                            <td>Ngân hàng Đầu tư Phát triển Việt Nam</td>
                            <td>Joint Stock Commercial Bank for Investment and Development of Vietnam</td>
                            <td>BIDVVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>Citibank</strong></td>
                            <td>Ngân hàng Citibank</td>
                            <td>Citibank Vietnam</td>
                            <td>CITIVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>Đông Á Bank</strong></td>
                            <td>Ngân hàng Đông Á</td>
                            <td>East Asia Commercial Joint Stock Bank</td>
                            <td>EACBVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>Eximbank</strong></td>
                            <td>Ngân hàng Xuất nhập khẩu Việt Nam</td>
                            <td>Vietnam Export Import Commercial Joint Stock Bank</td>
                            <td>EBVIVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>HDBank</strong></td>
                            <td>Ngân hàng phát triển Tp. HCM</td>
                            <td>HCM City Development Joint Stock Bank</td>
                            <td>HDBCVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>HoleongBank</strong></td>
                            <td>Ngân hàng HongLeong</td>
                            <td>Hong Leong Bank Vietnam</td>
                            <td>HLBBVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>KienlongBank</strong></td>
                            <td>Ngân hàng Kiên Long</td>
                            <td>Kien Long Commercial Joint Stock Bank</td>
                            <td>KLBKVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>LienVietPostBank</strong></td>
                            <td>Ngân hàng LienVietPostBank</td>
                            <td>Lien Viet Post Joint Stock Commercial Bank</td>
                            <td>LVBKVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>MBBank</strong></td>
                            <td>Ngân hàng quân đội</td>
                            <td>Military Commercial Joint Stock Bank</td>
                            <td>MSCBVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>Maritime Bank</strong></td>
                            <td>Ngân hàng Maritime Việt Nam</td>
                            <td>Vietnam Maritime Commercial Joint Stock Bank</td>
                            <td>MCOBVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>NamABank</strong></td>
                            <td>Ngân hàng Nam Á</td>
                            <td>Nam A Commercial Joint Stock Bank</td>
                            <td>NAMAVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>NCB</strong></td>
                            <td>Ngân hàng Quốc dân</td>
                            <td>National Citizen Commercial&nbsp;Bank</td>
                            <td>NVBAVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>OCB</strong></td>
                            <td>Ngân hàng Phương Đông</td>
                            <td>Orient Commercial Joint Stock Bank</td>
                            <td>ORCOVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>OceanBank</strong></td>
                            <td>Ngân hàng Đại Dương</td>
                            <td>Ocean Commercial One Member Limited Library Bank</td>
                            <td>OJBAVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>PVcomBank</strong></td>
                            <td>Ngân hàng Đại Chúng</td>
                            <td>Vietnam Public Joint Stock Commercial Bank</td>
                            <td>WBVNVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>PGBank</strong></td>
                            <td>Ngân hàng TMCP Xăng Dầu Việt Nam</td>
                            <td>Petrolimex Group Commercial Joint Stock Bank</td>
                            <td>PGBLVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>SaigonBank</strong></td>
                            <td>Ngân hàng Sài Gòn Công thương</td>
                            <td>Saigon Bank for Industry and Trade</td>
                            <td>SBITVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>Sacombank</strong></td>
                            <td>Ngân hàng Sài Gòn Thương Tín</td>
                            <td>Saigon Thuong Tin Commercial Joint Stock Bank</td>
                            <td>SGTTVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>SCB</strong></td>
                            <td>Ngân hàng TMCP Sài Gòn</td>
                            <td>Saigon Commercial Bank</td>
                            <td>SACLVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>SHB</strong></td>
                            <td>Ngân hàng TMCP Sài Gòn- Hà Nội</td>
                            <td>Saigon- Ha Noi Commercial Joint Stock Bank</td>
                            <td>SHBAVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>SeaBank</strong></td>
                            <td>Ngân hàng Đông Nam Á</td>
                            <td>SouthEast Asia Commercial Joint Stock Bank</td>
                            <td>SEAVVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>Techcombank</strong></td>
                            <td>Ngân hàng Kỹ Thương Việt Nam</td>
                            <td>Vietnam Technology and Commercial Joint Stock Bank</td>
                            <td>VTCBVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>TPBank</strong></td>
                            <td>Ngân hàng Tiên Phòng</td>
                            <td>Tienphong Commercial Joint Stock Bank</td>
                            <td>TPBVVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>VIB</strong></td>
                            <td>Ngân hàng Quốc tế</td>
                            <td>Vietnam International Commercial Joint Stock Bank</td>
                            <td>VNIBVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>Vietcombank</strong></td>
                            <td>Ngân hàng Ngoại thương Việt Nam</td>
                            <td>Joint Stock Commercial Bank for Foreign Trade of Vietnam</td>
                            <td>BFTVVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>Vietinbank</strong></td>
                            <td>Ngân hàng Công thương</td>
                            <td>Vietnam Joint Stock Commercial Bank for Industry and Trade</td>
                            <td>ICBVVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>Vietcapital Bank</strong></td>
                            <td>Ngân hàng Bản Việt</td>
                            <td>Vietcapital Commercial Joint Stock Bank</td>
                            <td>VCBCVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>VPBank</strong></td>
                            <td>Ngân hàng Việt Nam Thịnh Vượng</td>
                            <td>Vietnam Prosperity Joint Stock Commercial Bank</td>
                            <td>VPBKVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>IndovinaBank</strong></td>
                            <td>Ngân hàng Indovina</td>
                            <td>Indovina Bank LTD.</td>
                            <td>IABBVNVX</td>
                        </tr>
                        <tr>
                            <td><strong>HSBC</strong></td>
                            <td>Ngân hàng HSBC</td>
                            <td>HSBC Private International Bank</td>
                            <td>HSBCVNVX</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <p>
                    Từ khóa: swift code là gì, swift code dùng để làm gì, swift code ngân hàng Vietinbank, swift code ngân hàng ACB, swift code ngân hàng Vietcombank, swift code ngân hàng MBBank, swift code ngân hàng Sacombank, swift code ngân hàng BIDV, swift code ngân hàng Agribank, swift code ngân hàng SeABank, swift code ngân hàng VPBank, tên tiếng Anh ngân hàng tại Việt Nam
                </p>
            </div>
            <div class="col-lg-4">
                d
            </div>
        </div>
    </div>
</section>
@endsection
