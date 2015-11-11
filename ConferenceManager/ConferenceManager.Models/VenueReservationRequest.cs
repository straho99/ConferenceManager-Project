namespace ConferenceManager.Models
{
    using System.ComponentModel.DataAnnotations;
    using System.ComponentModel.DataAnnotations.Schema;

    public class VenueReservationRequest
    {
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public long Id { get; set; }

        [Required]
        public long VenueId { get; set; }

        public Venue Venue { get; set; }

        [Required]
        public long ConferenceId { get; set; }

        public Conference Conference { get; set; }

        [Required]
        public RequestStatus Status { get; set; }
    }
}
