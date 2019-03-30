import React, { Component } from 'react';
import './courseSmall.scss';
class CourseSmall extends Component {
  render() {
    return (
      <div>
        <h1 className="small-card__title">
          {this.props.course.name}
        </h1>
        <div className="card-labels mt-4">
        <button className="course-header__button">{this.props.course.category}</button>&nbsp;
        {this.props.course.labels.map((label, idx) => (
              <button className="labels__btn labels__btn--matiere" title="Département" key={idx}>{label}</button>
        ))}
        </div>
      </div>
    );
  }
}

export default CourseSmall;
