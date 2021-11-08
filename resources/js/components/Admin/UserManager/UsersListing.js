import React, { useState, useEffect } from "react";
import axios from "axios";
import { Table } from 'reactstrap';
import UserTableRow from "./UserTableRow";

export default function UserList(props) {
    const [expenses, setUser] = useState([]);

    useEffect(() => {
        const fetchData = async () => {
            const result = await axios("http://localhost:8000/api/user/");   
            setUser(result.data);
        };
        fetchData();
    }, []);

    const DataTable = expenses.map((res, i) => {
        return <UserTableRow obj={res} key={i} />;
    });

    return (
        <div className="table-wrapper">
            <Table striped hover>
                <thead>
                    <tr>
                        <th>UserName</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Password</th>
                        <th>type</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>{DataTable}</tbody>
            </Table>
        </div>
    );
}
