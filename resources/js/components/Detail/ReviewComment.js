import React, { Component } from 'react'
import '../../../css/ReviewComment.css';
export default class ReviewComment extends Component {
    render() {
        return (
            <div className="review-comment">
                <div className="container">
                    <div className="review-title">
                        <p>Review</p>
                    </div>
                    <div className="btnCmt-review">
                            <button className="btnCmt">Write a Review</button>
                            <button className="btnReview">View</button>
                    </div>
                    {/* Xem đánh giá sản phẩm */}
                    {/* <div className="review-product">
                        <div className="user-review">
                            <div className="name-user">
                                <p>Nhu</p>
                            </div>
                            <div className="icon-review">
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                            </div>
                            <div className="review-content mt-3">
                                <p>Sản phẩm tuyệt vời</p>
                            </div>
                        </div>
                    </div> */}
                </div>
            </div>
        )
    }
}
