namespace ConferenceManager.Models
{
    using System;
    using System.Collections.Generic;
    using System.ComponentModel.DataAnnotations;
    using System.ComponentModel.DataAnnotations.Schema;

    public class Conference
    {
        private ICollection<Lecture> lectures;
        private ICollection<User> participants;

        private ICollection<VenueReservationRequest> venueReservationRequests;

        public Conference()
        {
            this.lectures = new HashSet<Lecture>();
            this.participants = new HashSet<User>();

            this.venueReservationRequests = new HashSet<VenueReservationRequest>();
        }

        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public long Id { get; set; }

        [Required]
        public string Name { get; set; }

        [Required]
        public DateTime StartDate { get; set; }

        [Required]
        public DateTime EndDate { get; set; }

        [Required]
        public long OwnerId { get; set; }

        public virtual User Owner { get; set; }

        //public long VenueId { get; set; }

        public virtual Venue Venue { get; set; }

        public virtual ICollection<Lecture> Lectures
        {
            get
            {
                return this.lectures;
            }

            set
            {
                this.lectures = value;
            }
        }

        public virtual ICollection<User> Participants
        {
            get
            {
                return this.participants;
            }

            set
            {
                this.participants = value;
            }
        }

        public virtual ICollection<VenueReservationRequest> VenueReservationRequests
        {
            get
            {
                return this.venueReservationRequests;
            }

            set
            {
                this.venueReservationRequests = value;
            }
        }
    }
}
