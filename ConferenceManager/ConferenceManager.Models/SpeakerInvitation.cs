namespace ConferenceManager.Models
{
    using System.ComponentModel.DataAnnotations;
    using System.ComponentModel.DataAnnotations.Schema;

    public class SpeakerInvitation
    {
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public long Id { get; set; }

        [Required]
        public long LectureId { get; set; }

        public Lecture Lecture { get; set; }

        [Required]
        public long SpeakerId { get; set; }

        public User Speaker { get; set; }

        [Required]
        public RequestStatus Status { get; set; }
    }
}
