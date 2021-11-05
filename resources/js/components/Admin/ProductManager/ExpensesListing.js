import React, { useState, useEffect } from "react";
import axios from "axios";
import { Table } from 'reactstrap';
import ExpenseTableRow from "./ExpenseTableRow";

export default function ExpenseList(props) {
    const [expenses, setExpenses] = useState([]);
    const [checkGetAPI, setCheckGetAPI] = useState(true);

    useEffect(() => {
        const fetchData = async () => {
            const result = await axios("http://localhost:8000/api/product/");
            setExpenses(result.data);
            if (expenses.length === 0) setCheckGetAPI(false);
        };
        fetchData();
        /*axios
            .get("http://localhost:8000/api/expenses/")
            .then((res) => {
                setExpenses([...res.data]);
            })
            .catch((error) => {
                console.log(error);
            });*/
    }, [checkGetAPI]);

    const DataTable = expenses.map((res, i) => {
        return <ExpenseTableRow obj={res} key={i} />;
    });

    return (
        <div className="table-wrapper">
            <Table striped bordered hover>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>{DataTable}</tbody>
            </Table>
        </div>
    );
}
