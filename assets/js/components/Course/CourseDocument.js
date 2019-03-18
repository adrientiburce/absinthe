import React, { Component } from 'react';
import Moment from 'react-moment';

class CourseDocument extends Component {

  render() {
    if (this.props.course.documents.length != 0) {
    return(
      <table className="table full-width">
        <thead>
          <tr>
              <th>Document</th>
              <th>Auteur</th>
              <th>Date d'upload</th>
          </tr>
        </thead>
        <tbody>
      {this.props.course.documents.map((document, idx) => (
        <tr key={idx}>
          <td>
            <a href={`${this.props.base}/course/document/${document["name"]}`} className="link-upload" download={`${document["name"]}`} title="Télécharger"> {document["name"]}</a> &nbsp; 
            <span className="document--btn">{document["label"]}</span>
          </td> 
          <td>
            <span>{document["author"]}</span>
          </td>
          <td>
            <span>
              <Moment format="D MMM YYYY" withTitle>
              {document["date"]}
              </Moment>
            </span>
          </td>
        </tr>
      ))}
        </tbody>
      </table>
    )
    }
    else{
      return(
        <p>Ce cours ne possède actuellement aucun document</p>
      );
    }
}
}

export default CourseDocument;
