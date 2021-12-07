import React, { useState } from "react";
import { AvForm, AvField } from "availity-reactstrap-validation";
import { Button } from "reactstrap";
import { Link, useHistory } from "react-router-dom";
import Swal from "sweetalert2";
import "../../../css/Info.css";
export default function Info({ setInfoUser, setIsLogin }) {
    const [oldInfoData, setOldInfoData] = useState({});
    const [infoData, setInfoData] = useState({
        email: "",
        phone: "",
        address: "",
    });
    //Call API logout
    const doLogout = () => {
        Swal.fire({
            showCancelButton: true,
            confirmButtonText: "Yes",
            title: "Do you want logout ?",
            icon: "question",
        }).then((result) => {
            if (result.isConfirmed) {
                setIsLogin({ isLoginStatus: false });
                setInfoUser({
                    email: "",
                    phone: "",
                    address: "",
                });
                if (localStorage.getItem("loginToken")) {
                    let tokenStr = localStorage.getItem("loginToken");
                    axios.get("http://localhost:8000/api/logout/", {
                        headers: { Authorization: `Bearer ${tokenStr}` },
                    });
                    localStorage.removeItem("loginToken");
                }
            }
        });
    };
    //Save data when input change
    const handleChange = (e) => {
        const { name, value } = e.target;
        setInfoData((infoData) => ({
            ...infoData,
            [name]: value,
        }));
    };

    useEffect(() => {
        if (localStorage.getItem("loginToken")) {
            let tokenStr = localStorage.getItem("loginToken");
            //Pass tokenLogin at Authorization of headers
            const fetchData = async () => {
                const result = await axios("http://localhost:8000/api/info/", {
                    headers: { Authorization: `Bearer ${tokenStr}` },
                });
                setInfoData({
                    ...result.data,
                });
                setInfoUser({
                    ...result.data,
                });
                setOldInfoData({
                    ...result.data,
                });
            };
            fetchData();
        }
    }, []);

    const doUpdateInfo = (event, values) => {
        Swal.fire({
            showCancelButton: true,
            confirmButtonText: "Save",
            title: "Do you want updated ?",
            icon: "question",
        }).then((result) => {
            if (result.isConfirmed) {
                if (checkOldInfoData(infoData, oldInfoData)) {
                    let infoUpdate = {
                        old_email: values.old_email,
                        old_phone: values.old_phone,
                        old_address: values.old_address,
                        ...infoData,
                    };

                    let tokenStr = localStorage.getItem("loginToken");
                    axios
                        .post("http://localhost:8000/api/info/", infoUpdate, {
                            headers: { Authorization: `Bearer ${tokenStr}` },
                        })
                        .then((res) => {
                            Swal.fire(
                                "Good job!",
                                "Updated Successfully",
                                "success"
                            );
                        })
                        .catch((err) => {
                            Swal.fire({
                                title: "Error!",
                                text: "Do you want to continue ?",
                                icon: "error",
                                confirmButtonText: "Cool",
                            });
                            console.log(err);
                        });
                } else {
                    Swal.fire({
                        title: "Pls type anything you want to update!",
                        text: "Do you want to continue ?",
                        icon: "error",
                        confirmButtonText: "Cool",
                    });
                }
            }
        });
    };

    const checkOldInfoData = (infoData, oldInfoData) => {
        let flag = true;
        infoData.email === oldInfoData.email ? (flag = false) : (flag = true);
        infoData.phone === oldInfoData.phone ? (flag = false) : (flag = true);
        infoData.address === oldInfoData.address
            ? (flag = false)
            : (flag = true);
        return flag;
    };

    const handleInvalidSubmit = (event, errors, values) => {
        Swal.fire({
            title: "Error!",
            text: "Do you want to continue ?",
            icon: "error",
            confirmButtonText: "Cool",
        });
    };
    return (
        <div className="info container mt-5 mb-5">
            <h1 className="info-title text-center">WELCOME BACK</h1>
            <AvForm
                onValidSubmit={doUpdateInfo}
                onInvalidSubmit={handleInvalidSubmit}
            >
                <AvField
                    name="email"
                    label="Email"
                    type="text"
                    placeholder="Email here..."
                    value={infoLogin.username}
                    validate={{
                        required: {
                            value: true,
                            errorMessage: "Please enter your email",
                        },
                        email: {
                            value: true,
                            errorMessage: "Your email not correct",
                        },
                    }}
                />
                <AvField
                    name="fullname"
                    label="Fullname"
                    placeholder="Fullname here..."
                    type="text"
                    value={infoLogin.fullname}
                    validate={{
                        required: {
                            value: true,
                            errorMessage: "Please enter your fullname",
                        },
                        pattern: {
                            value: "^[A-Za-z]+$",
                            errorMessage:
                                "Your password must be composed only with letter",
                        },
                        minLength: {
                            value: 6,
                            errorMessage:
                                "Your password must be between 6 and 16 characters",
                        },
                        maxLength: {
                            value: 16,
                            errorMessage:
                                "Your password must be between 6 and 16 characters",
                        },
                    }}
                />
                <AvField
                    name="birthday"
                    label="Birthday"
                    type="date"
                    value={infoLogin.birthday}
                    validate={{
                        required: {
                            value: true,
                            errorMessage: "Please enter your birthday",
                        },
                    }}
                />
                <AvField
                    name="phone"
                    label="Phone"
                    placeholder="Phone here..."
                    type="tel"
                    value={infoLogin.phone}
                    validate={{
                        required: {
                            value: true,
                            errorMessage: "Please enter your phone",
                        },
                    }}
                />
                <Button
                    type="submit"
                    color="secondary"
                    className="btn-md btn-block"
                >
                    Update
                </Button>
                <Link to="/">
                    <Button
                        color="outline-secondary"
                        className="btn-md btn-block mt-2"
                        id="btnBack"
                    >
                        Back to Home
                    </Button>
                </Link>
            </AvForm>
        </div>
    );
}
