import React from "react";

const Course = (props) => {
       return(
        <div className="container jumbotron mt-4">
            <h1 className="text-center text-info">{ props.course.name }</h1>
            <button className="text-right btn btn-primary">{props.course.category}</button>
            <p className="text-center">{ props.course.description}</p>
       </div>
    );
}

export default Course