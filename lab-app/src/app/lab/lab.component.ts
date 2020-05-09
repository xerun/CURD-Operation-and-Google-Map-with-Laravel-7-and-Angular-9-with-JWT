import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { HttpClient } from '@angular/common/http'
import { environment } from '../../environments/environment';
import { LabService } from '../_services/lab.service';
import { Location } from '../_models/location.model';
import Swal from 'sweetalert2'

@Component({
  selector: 'app-lab',
  templateUrl: './lab.component.html',
  styles: [
  ]
})

export class LabComponent implements OnInit {
  locList : any=[];

  constructor(private http:HttpClient, public service: LabService) { }

  ngOnInit(): void {
    this.resetForm();
    this.locationList();
  }

  locationList(){
    this.http.get(`${environment.apiUrl}/locations`)
    .toPromise()
    .then(res => this.locList = res as Location[]);
  }

  resetForm(form?:NgForm)
  {
    if(form!=null)
      form.form.reset();
    this.service.formData = {
      id: 0,
      name: '',
      location_id: 0,
      location_name: '',
      created_at: new Date(),
      updated_at: new Date()
    }
  }

  onSubmit(form: NgForm){
    if(this.service.formData.id == 0)
      this.insert(form);
    else
      this.update(form);
  }

  insert(form: NgForm)
  {
    this.service.postLab().subscribe(
      res => {
        this.resetForm(form);
        Swal.fire('Great!', 'Information has been saved', 'success');
        this.service.reloadList();
      },
      err => {
        console.log(err);
      }
    );
  }

  update(form: NgForm)
  {
    this.service.putLab().subscribe(
      res => {
        this.resetForm(form);
        Swal.fire('Great!', 'Information has been updated', 'success');
        this.service.reloadList();
      },
      err => {
        console.log(err);
      }
    );
  }
}
