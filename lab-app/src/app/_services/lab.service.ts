import { Injectable } from '@angular/core';
import { Lab } from '../_models/lab.model';
import { HttpClient } from '@angular/common/http'
import { environment } from '../../environments/environment';

import { throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class LabService {
  formData: Lab;
  list : any=[];

  constructor(private http:HttpClient) { }

  postLab(){
    return this.http.post(`${environment.apiUrl}/labs`, this.formData)
    .pipe(
      catchError(this.errorHandler)
    );
  }

  putLab(){
    return this.http.put(`${environment.apiUrl}/labs/${this.formData.id}`, this.formData)
    .pipe(
      catchError(this.errorHandler)
    );
  }

  deleteLab(id:number){
    return this.http.delete(`${environment.apiUrl}/labs/`+id)
    .pipe(
      catchError(this.errorHandler)
    );
  }

  reloadList(){
    this.http.get(`${environment.apiUrl}/labs`)
    .toPromise()
    .then(res => this.list = res as Lab[]);
  }

  errorHandler(error) {
    let errorMessage = '';
    if(error.error instanceof ErrorEvent) {
      // Get client-side error
      errorMessage = error.error.message;
    } else {
      // Get server-side error
      errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;
    }
    console.log(errorMessage);
    return throwError(errorMessage);
 }
}
