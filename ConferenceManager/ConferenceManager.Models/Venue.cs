namespace ConferenceManager.Models
{
    using System.Collections.Generic;
    using System.ComponentModel.DataAnnotations;
    using System.ComponentModel.DataAnnotations.Schema;

    public class Venue
    {
        private ICollection<Hall> halls;
        private ICollection<Conference> conferences;

        private ICollection<VenueReservationRequest> reservationRequests;

        public Venue()
        {
            this.halls = new HashSet<Hall>();
            this.conferences = new HashSet<Conference>();

            this.reservationRequests = new HashSet<VenueReservationRequest>();
        }

        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public long Id { get; set; }

        [Required]
        public string Name { get; set; }

        [Required]
        public string Description { get; set; }

        [Required]
        public string Address { get; set; }

        [Required]
        public long OwnerId { get; set; }

        public virtual User Owner { get; set; }

        public virtual ICollection<Hall> Halls
        {
            get
            {
                return this.halls;
            }

            set
            {
                this.halls = value;
            }
        }

        public virtual ICollection<Conference> Conferences
        {
            get
            {
                return this.conferences;
            }

            set
            {
                this.conferences = value;
            }
        }

        public virtual ICollection<VenueReservationRequest> ReservationRequests
        {
            get
            {
                return this.reservationRequests;
            }

            set
            {
                this.reservationRequests = value;
            }
        }
    }
}
