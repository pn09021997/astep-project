import React, { Component } from 'react'
import '../../../css/RelatedContent.css';
export default class RelatedContent extends Component {
    render() {
        return (
            <div>
                <div className="container">
                    <div className="row mt-5">
                        {/*Sản phẩm liên quan cùng categories*/}
                        <div className="related-product">
                            <div className="title-related">
                                <h3>Related Products</h3>
                            </div>
                            <div className="row my-5">
                                <div className="col-md-3">
                                    <img src="https://product.hstatic.net/200000065946/product/pro_nau_ghe_bang_tua_go_cao_su_tu_nhien_vline_602_1_2_237fdbb588034714948022f20854e158_grande.png" width="100%" height="75%"></img>
                                    <div className="related-content">
                                        <p>Ghế Ăn Gỗ Cao Su Tự Nhiên MOHO OSLO 601</p>
                                        <div className="related-price">
                                            <p>799,000₫</p>
                                        </div>
                                    </div>
                                </div>
                                <div className="col-md-3">
                                    <img src="https://product.hstatic.net/200000065946/product/pro_mau_tu_nhien_noi_that_moho_ghe_an_odessa_2e9569c22c6d45749107e0a44f6c4d9c_master.png" width="100%" height="75%"></img>
                                    <div className="related-content">
                                        <p>Ghế Ăn Gỗ Cao Su Tự Nhiên MOHO OSLO 601</p>
                                        <div className="related-price">
                                            <p>799,000₫</p>
                                        </div>
                                    </div>
                                </div>
                                <div className="col-md-3">
                                    <img src="https://product.hstatic.net/200000065946/product/pro_mau_tu_nhien_ghe_an_go_torino_11092c6f4b2d40c9a4587b48f49268b7_master.png" width="100%" height="75%"></img>
                                    <div className="related-content">
                                        <p>Ghế Ăn Gỗ Cao Su Tự Nhiên MOHO OSLO 601</p>
                                        <div className="related-price">
                                            <p>799,000₫</p>
                                        </div>
                                    </div>
                                </div>
                                <div className="col-md-3">
                                    <img src="https://product.hstatic.net/200000065946/product/pro_mau_tu_nhien_ghe_bang_dai_go_cao_su_tu_nhien_vline_602_2a_84e297a28a5e472faf47291b08521740_master.jpg" width="100%" height="75%"></img>
                                    <div className="related-content">
                                        <p>Ghế Ăn Gỗ Cao Su Tự Nhiên MOHO OSLO 601</p>
                                        <div className="related-price">
                                            <p>799,000₫</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}
