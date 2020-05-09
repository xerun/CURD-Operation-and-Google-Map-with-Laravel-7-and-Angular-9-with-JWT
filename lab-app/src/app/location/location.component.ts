import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { HttpClient } from '@angular/common/http'
import { LocationService } from '../_services/location.service';
import Swal from 'sweetalert2'

@Component({
  selector: 'app-location',
  templateUrl: './location.component.html',
  styles: [
  ]
})

export class LocationComponent implements OnInit {

  constructor(private http:HttpClient, public service: LocationService) { }

  ngOnInit(): void {
    this.resetForm();
  }  

  resetForm(form?:NgForm)
  {
    if(form!=null)
      form.form.reset();
    this.service.formData = {
      id: 0,
      name: '',
      address: '',
      latitude: 0,
      longitude: 0,
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
    this.service.postLocation().subscribe(
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
    this.service.putLocation().subscribe(
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
