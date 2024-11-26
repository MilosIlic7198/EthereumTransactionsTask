import NotFound from "./components/NotFound";
import Home from "./components/Home";
import Transactions from "./components/Transactions";

const routes = [
    {
        path: "/transactions",
        component: Transactions,
        name: "Transactions",
    },
    {
        path: "/",
        component: Home,
        name: "Home",
    },
    {
        path: "*",
        component: NotFound,
        name: "NotFound",
    }
]

export default routes;
