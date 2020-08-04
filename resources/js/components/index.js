import React from "react";
import ReactDOM from "react-dom";

import Login from "./auth/login";
import Register from "./auth/register";

const App = () => {
    return (
        <Router>
            <Switch>
                <Route exact path="/api/login" component={Login} />
                <Route exact path="/api/register" component={Register} />
            </Switch>
        </Router>
    );
};

export default App;

ReactDOM.render(<App />, document.getElementById("root"));
