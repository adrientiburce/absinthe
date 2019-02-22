import React from 'react';
import CourseSmall from './CourseSmall';
import { Link } from 'react-router-dom';

const CourseList = props => (
  <div>
  <h1 className="courses-title"> Les Cours </h1>
  <div className="block-courses">
    {props.courses.map((course, idx) => (
        <Link to={'/cours/' + course.id }>
        <div key={idx} class="card-courses">
          <CourseSmall key={idx} course={course} idx={idx} />
        </div>
      </Link>
    ))}
  </div>
  </div>
)

export default CourseList;
