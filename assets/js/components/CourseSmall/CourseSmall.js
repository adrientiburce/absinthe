import React, { Component } from 'react';
import './courseSmall.scss';
class CourseSmall extends Component {
  render() {
    return (
      <div>
        <h1 className="small-card__title">
          <span className="title--reSize">{this.props.course.name}</span>
        </h1>
        <div className="card-labels">
        <div>
        <button className="course-header__button">{this.props.course.category}</button>
        </div>
        <div className="card-labels__flex">
        {this.props.course.labels.map((label, idx) => (
              <button className="labels__btn labels__btn--matiere" title="Département" key={idx}>{label}</button>
        ))}
        </div>
        </div>
      </div>
    );
  }
}

export default CourseSmall;
