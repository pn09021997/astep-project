import React from "react";
import { Link } from "react-router-dom";
import { Button} from 'reactstrap';
import axios from "axios";
import Swal from "sweetalert2";

export default function ExpenseTableRow(props) {
    const deleteExpense = () => {
        axios
            .delete("http://localhost:8000/api/expenses/" + props.obj.id)
            .then((res) => {
                Swal.fire("Good job!", "Expense Delete Successfully", "success");
            })
            .catch((error) => {
                console.log(error);
            });
    };

    return (
        <tr>
            <td>{props.obj.name}</td>
            <td>{props.obj.amount}</td>
            <td>{props.obj.description}</td>
            <td>
                <Link
                    className="edit-link"
                    to={"/edit-expense/" + props.obj.id}
                >
                    <Button size="sm" variant="info">
                        Edit
                    </Button>
                </Link>
                <Button onClick={deleteExpense} size="sm" variant="danger">
                    Delete
                </Button>
            </td>
        </tr>
    );
}
