import React from 'react';
import CourseSmall from './CourseSmall';
import { Link } from 'react-router-dom';

const CourseList = props => (
  <div>
  <h1 className="courses-title">Cours : {props.courses[1].category}</h1>
  <div className="block-courses">
    {props.courses.map((course, idx) => (
        <Link to={'/cours/' + course.id} key={idx}>
        <div className="card-courses">
          <CourseSmall course={course} idx={idx} />
        </div>
      </Link>
    ))}
  </div>
  </div>
)

export default CourseList;
