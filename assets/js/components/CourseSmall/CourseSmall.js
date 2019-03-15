import React, { Component } from 'react';

class CourseSmall extends Component {
  render() {
    return (
      <div>
        <h1 className="card-course__header__title">
          {this.props.course.name}
        </h1>
        <button className="card-course__header__button">{this.props.course.category}</button>
      </div>
    );
  }
}

export default CourseSmall;
