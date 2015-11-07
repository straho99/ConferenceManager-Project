namespace ConferenceManager.Models
{
    using System.ComponentModel.DataAnnotations;

    public class VenueReservationRequest
    {
        [Key]
        public int Id { get; set; }

        [Required]
        public int VenueId { get; set; }

        public Venue Venue { get; set; }

        [Required]
        public int ConferenceId { get; set; }

        public Conference Conference { get; set; }

        [Required]
        public RequestStatus Status { get; set; }
    }
}
