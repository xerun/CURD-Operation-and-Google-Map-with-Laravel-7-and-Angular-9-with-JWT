import { Component, OnInit } from '@angular/core';
import { LocationService } from '../_services/location.service';
import Swal from 'sweetalert2'

@Component({
  selector: 'app-location-list',
  templateUrl: './location-list.component.html',
  styles: [
  ]
})
export class LocationListComponent implements OnInit {

  constructor(public service: LocationService) { }

  ngOnInit(): void {
    this.service.reloadList();
  }

  fillForm(selected){ 
    this.service.formData = Object.assign({},selected);
  }

  onDelete(id: number) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You will not be able to recover this record!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, keep it'
    }).then((result) => {
      if (result.value) {
        this.service.deleteLocation(id)
        .subscribe(
          data => {
            Swal.fire(
              'Deleted!',
              'The Record has been deleted.',
              'success'
            );
            this.service.reloadList();
          },
          error => console.log(error));
        
      // For more information about handling dismissals please visit
      // https://sweetalert2.github.io/#handling-dismissals
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire(
          'Cancelled',
          'Your record is safe :)',
          'error'
        )
      }
    });    
  }

}
