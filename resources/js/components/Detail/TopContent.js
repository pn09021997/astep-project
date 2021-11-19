import React, { Component } from 'react'
import '../../../css/TopContent.css';
export default class TopContent extends Component {
    render() {
        return (
            <div className="detail">
                <div className="detail-header">
                    <h1>Detail Product</h1>
                </div>
                <div className="container">
                    <div className="row">
                        <div className="col-lg-6 col-md-12">
                            <div className="img-detail">
                                <img src="//product.hstatic.net/200000065946/product/pro_mau_tu_nhien_noi_that_moho_ghe_an_pallermo_2265922503c242a98a1662e68fc16a70_master.png" width="100%" height="100%" />
                            </div>
                        </div>
                        <div className="col-lg-6 col-md-12">
                            <div className="header-detail">
                                <div className="titlle-detail my-3">
                                    <h3>Ghế Ăn Gỗ Tần Bì Tự Nhiên PALLERMO</h3>
                                </div>
                                <div className="quantity-review">
                                    <p>Đánh giá: </p>
                                </div>
                                {/* Nội dung chi tiết sản phẩm */}
                                <div className="description-detail">
                                    <div className="title-description">
                                        <p><b>Kích thước:</b> <br/>
                                         Dài 52cm x Rộng 58cm x Cao đến đệm ngồi/lưng tựa 50cm/78cm <br/> <br/>
                                            <b> Chất liệu:</b> <br />
                                            - Gỗ tần bì tự nhiên <br />
                                            - Vải bọc polyester chống nhăn, kháng bụi bẩn và nấm mốc <br />
                                            Chống thấm, cong vênh, trầy xước, mối mọt
                                        </p>
                                    </div>
                                    <div className="price-detail">
                                        <p>1,390,000₫</p>
                                    </div>
                                </div>

                                <div className="add-product-cart">
                                    <button type="button" className="btn-3"><span className="fs-3">Thêm vào giỏ</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}
