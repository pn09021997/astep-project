import React from 'react';
import "../../../css/navbarfooter.css";
export default function Navbar() {
    return (
        <div>
            <nav className="navbar navbar-expand-sm navbar-dark">
                <a className="navbar-brand" ><i className="fa fa-phone"></i>Hotline:0969012033</a>
                <button className="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span className="navbar-toggler-icon"></span>
                </button>
                <div className="collapse navbar-collapse" id="collapsibleNavId">
                    <ul className="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li className="nav-item active">
                            <a className="nav-link"><i className="fa fa-phone"></i>Hotline:0969012033</a>
                        </li>
                        <li className="nav-item">
                            <a className="nav-link" ><i className="fa fa-pencil-square-o"></i>Check your order</a>
                        </li>
                        <li className="nav-item">
                            <a className="nav-link"><i className="fa fa-shopping-cart"></i>Cart</a>
                        </li>
                        <li className="nav-item">
                            <a className="nav-link"><i className="fa fa-sign-in"></i>Log in </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <section className="header-content clearfix">
                <div className="container">
                    <div className="row">
                        <div className="col-md-3 col-sm-3 col-xs-12 logo text-center">
                            <a title="">
                                <img alt="" src="http://runecom53.runtime.vn/Uploads/shop300/images/DT/Untitled-1.png" className="logo" />
                            </a>
                        </div>
                        <div className="col-md-6 col-sm-5 col-xs-12 top-search">
                            <div className="search">
                                <div className="input-cat form-search clearfix">
                                    <div className="form-search-controls  input-group">
                                        <input type="text" name="search" id="txtsearch" />
                                        <span className="input-group-btn">
                                            <button className="btn btn-search" title="Search" type="submit" id="btnsearch" value="Search">
                                                <i className="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div className="social-group">
                            </div>
                        </div>
                        <div className="col-md-3 col-sm-4 col-xs-12 top-cart  hidden-xs">
                            <div className="cart" id="cart">
                                <div className="heading">
                                    <a>
                                        <span className="icon">icon</span><span id="cart-total">
                                            sp - 0đ
                                        </span><i className="fa fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <nav className="navbar navbar-expand-sm navbar-dark bg-dark">
                    <a className="navbar-brand">Home</a>
                    <button className="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span className="navbar-toggler-icon"></span>
                    </button>
                    <div className="collapse navbar-collapse" id="collapsibleNavId">
                        <ul className="navbar-nav mr-auto mt-2 mt-lg-0">
                            <li className="nav-item active">
                                <a className="nav-link" >Introduce <span className="sr-only">(current)</span></a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link">Product</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link">New</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link">Contact</a>
                            </li>
                        </ul>
                    </div>
                </nav>


        </div>
    )
}

