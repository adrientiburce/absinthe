import React from 'react';
import Course from './Course';
import { Link } from 'react-router-dom';

const CourseList = props => (
  <div>
    {props.courses.map((course, idx) => (
      <div key={idx}>
        <Link to={'/cours/' + course.id }>
          <Course key={idx} course={course} id={idx} />
        </Link>
      </div>
    ))}
  </div>
)

export default CourseList
