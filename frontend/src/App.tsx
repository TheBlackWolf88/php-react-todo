import { useEffect, useState, type ChangeEvent, type MouseEvent } from "react";

interface Todo {
    id: number;
    name: string;
    is_complete: boolean;
}

async function handleComplete(e: ChangeEvent<HTMLInputElement>) {
    const action = e.target.checked ? "complete" : "uncomplete";

    await fetch(
        `http://localhost:8080/todos/${e.target.id}/${action}`,
        {
            method: "PATCH",
        },
    )
    .catch(console.error);
}

function App() {
    const [items, setItems] = useState<Todo[]>([]);

    const fetchTodos = () => {
        fetch("http://localhost:8080/todos", { method: "get" })
            .then((res) => res.json())
            .then((todos) => setItems(todos))
            .catch(console.error);
    };

    const handleDelete = (
        id: number,
        e: MouseEvent<HTMLButtonElement, MouseEvent>,
    ) => {
        e.preventDefault();
        fetch(`http://localhost:8080/todos/${id}`, {
            method: "DELETE",
        })
            .then(() => fetchTodos())
            .catch(console.error);
    };

    const onFormSubmit = (fd: FormData) => {
        let body = { name: fd.get("todo-name") };
        fetch(`http://localhost:8080/todos`, {
            method: "post",
            headers: {
                "Content-Type": "application/json", // 👈 this is critical
            },
            body: JSON.stringify(body),
        })
            .then(() => fetchTodos())
            .catch(console.error);
    };

    useEffect(() => {
        fetchTodos();
    }, []);
    let itemLis = items.map((t) => (
        <li key={t.id}>
            <input
                id={t.id.toString()}
                type="checkbox"
                defaultChecked={t.is_complete}
                onChange={handleComplete}
            />
            {t.name}
            <button id={t.id.toString()} onClick={(e: any) => handleDelete(t.id, e)}>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    viewBox="0 0 16 16"
                >
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                </svg>
            </button>
        </li>
    ));
    return (
        <>
            <ul>{itemLis}</ul>
            <form action={onFormSubmit}>
                <input type="text" name="todo-name" id="todo-name" />
                <button>add</button>
            </form>
        </>
    );
}

export default App;
