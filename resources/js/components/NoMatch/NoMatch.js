import React from "react";
import { useLocation } from "react-router";

export default function NoMatch() {
    let location = useLocation();

    return (
        <div>
            <section className="page_404">
                <div className="container">
                    <div className="row">
                        <div className="col-sm-12 ">
                            <div className="col-sm-10 col-sm-offset-1  text-center">
                                <div className="four_zero_four_bg">
                                    <h1 className="text-center ">404 Not Page</h1>
                                </div>
                                <div className="contant_box_404">
                                    <h3 className="h2">
                                        no match for
                                        <code>{location.pathname}</code>
                                    </h3>

                                    <h3>
                                        the page you are looking for not
                                        avaible!
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
}
