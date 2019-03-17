import React, { Component } from 'react';
import CourseDocument from './CourseDocument';
import './course.scss';

class Course extends Component {
  constructor(props) {
    super(props);
    if (this.props.isLikedByUser) {
      this.state = {
        isLiked: this.props.isLikedByUser,
        message: null,
      };
    } else {
      this.state = {
        isLiked: false,
        message: null,
      };
    }
    this.handleClick = this.handleClick.bind(this);
  }

  handleClick() {
    const isLiked = this.state.isLiked;
    this.setState({
      isLiked: !isLiked,
      message: isLiked ? 'Favori retiré' : 'Favori ajouté',
    });
    // we call serverside
    fetch(`${this.props.base}/cours/favorite/${this.props.course.id}`)
      .then((response) => {
        console.log(response);
      });
  }

  render() {
    return (
      <div>
      <div className="card-course" key="1">
        <p className="text-success">{this.state.message}</p>
        <div className="card-course__header">
          <h1 className="header__title">
            <span id="course-like" onClick={this.handleClick} title={this.state.isLiked ? 'Enlever des favoris' : 'Ajouter aux favoris'}>
              <i className={this.state.isLiked ? 'fas fa-star' : 'far fa-star'} />
            </span>
&nbsp;
            {this.props.course.name}
          </h1>
          <button className="card-course__header__button">{this.props.course.category}</button>
        </div>
        <div className="card__legend">
          <p className="card-course__legend">{this.props.course.description}</p>
          <div className="card-lable">
            <div className="lable__category">
              <button className="course__btn" title="Semestre">{this.props.course.semester}</button>
              <button className="course__btn" title="Promotion">{this.props.course.promotion}</button>
            </div>
            <div className="lable__field">
            {this.props.course.labels.map((label, idx) => (
              <button className="course__btn course__btn--matiere" title="Département">{label}</button>
            ))}
            </div>
          </div>
        </div>
      </div>
      <div className="card-course" key="2">
        <h1 className="header__title">Documents</h1>

        <CourseDocument course={this.props.course} base={this.props.base}/> 
        <a className="card-document__upload" href={`${this.props.base}/upload`}>Uploader un document</a>
      </div>

    </div>
    );
  }
}

export default Course;
