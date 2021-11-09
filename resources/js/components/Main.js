import React from 'react'
import Navbar from './CartPage/Navbar'
import Cart from './CartPage/Cart'
import Footer from './CartPage/FooterCart'

export default function Main() {
    return (
        <div className="main">
            <Navbar></Navbar>
            <Cart></Cart>
           <Footer></Footer>
        </div>
    )
}
