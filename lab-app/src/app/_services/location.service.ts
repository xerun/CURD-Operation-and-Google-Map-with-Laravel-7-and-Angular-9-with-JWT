import { Injectable } from '@angular/core';
import { Location } from '../_models/location.model';
import { HttpClient } from '@angular/common/http'
import { environment } from '../../environments/environment';

import { throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class LocationService {
  formData: Location;
  list : any=[];

  constructor(private http:HttpClient) { }

  getLocation(id:number){
    return this.http.get(`${environment.apiUrl}/locations/${id}`)
    .pipe(
      catchError(this.errorHandler)
    );
  }

  postLocation(){
    return this.http.post(`${environment.apiUrl}/locations`, this.formData)
    .pipe(
      catchError(this.errorHandler)
    );
  }

  putLocation(){
    return this.http.put(`${environment.apiUrl}/locations/${this.formData.id}`, this.formData)
    .pipe(
      catchError(this.errorHandler)
    );
  }

  deleteLocation(id:number){
    return this.http.delete(`${environment.apiUrl}/locations/${id}`)
    .pipe(
      catchError(this.errorHandler)
    );
  }

  reloadList(){
    this.http.get(`${environment.apiUrl}/locations`)
    .toPromise()
    .then(res => this.list = res as Location[]);
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
