import React, {Component} from 'react';
import {Link} from 'react-router-dom';
import CourseSmall from '../CourseSmall';
import './courseList.scss';

/*const CourseList = props => (
  <div>
    <h1 className="courses-title">
        {props.title}
    </h1>
    <div className="block-courses">
      {props.courses.map((course, idx) => (
        <Link to={`/cours/${course.id}`} key={idx}>
          <div className="small-card">
            <CourseSmall course={course} idx={idx} />
          </div>
        </Link>
      ))}
    </div>
  </div>
);*/

class CourseList extends Component {
    render() {
        if (this.props.courses.length > 0) {
            return (
                <div>
                    <h1 className="courses-title">
                        {this.props.title}
                    </h1>
                    <div className="block-courses">
                        {this.props.courses.map((course, idx) => (
                            <Link to={`/cours/${course.id}`} key={idx}>
                                <div className="small-card">
                                    <CourseSmall course={course} idx={idx}/>
                                </div>
                            </Link>
                        ))}
                    </div>
                </div>
            )
        } else {
            return (
                <div>
                    <h1 className="courses-title">
                        {this.props.title}
                    </h1>
                    <p>Vous n'avez actuellement aucun cours favoris</p>
                </div>
            );
        }
    }
}

export default CourseList;
